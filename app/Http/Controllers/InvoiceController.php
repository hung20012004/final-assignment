<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Laptop;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
/**
    * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($search = $request->input('search')) {
            $query->where('id', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('provider', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $invoices = $query->get();

        return view('user.warehouse.invoice.index-invoice', compact('invoices'));
    }
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $laptops= Laptop::all();
        $providers = Provider::all();

        return view('user.warehouse.invoice.create-invoice', compact('providers','laptops'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $validatedData = $request->validate([
            'provider_id' => 'required|integer|exists:providers,id',
            'hidden_laptops' => 'required', // Đây là input ẩn chứa dữ liệu laptops
        ]);
    
        // Lấy dữ liệu từ hidden-laptops và chuyển đổi thành mảng PHP
        $laptopsData = json_decode($request->input('hidden_laptops'), true);

        $invoice = new Invoice();
        $invoice->user_id = $currentUser->id;
        $invoice->provider_id = $validatedData['provider_id'];
        $invoice->state = '1';
        $invoice->save();

        foreach ($laptopsData as $laptop) {
            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->laptop_id = $laptop['id'];
            $invoiceDetail->quantity = $laptop['quantity'];
            $invoiceDetail->price = $laptop['price'];
            $invoiceDetail->save();
            
            $laptopModel = Laptop::findOrFail($laptop['id']);
            $laptopModel->quantity += $laptop['quantity'];
            $laptopModel->save();
        }

        return redirect()->route('invoices.index')->with('success', 'Hóa đơn đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::findOrFail($invoice->id);

        return view('user.warehouse.invoice.show-invoice', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice = Invoice::findOrFail($invoice->id);
        $users = User::where('role', 'warehouse')->get();
        $providers = Provider::all();
        $laptops = Laptop::all();

    return view('user.warehouse.invoice.edit-invoice', compact('invoice', 'users', 'providers', 'laptops'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:providers,id',
            'state' => 'nullable|integer',
            'invoice_details' => 'nullable|array|min:1',
            'invoice_details.*.laptop_id' => 'required|exists:laptops,id',
            'invoice_details.*.quantity' => 'required|integer|min:1',
            'invoice_details.*.price' => 'required|numeric|min:0',
        ]);

        // Khôi phục lại số lượng của các chi tiết hóa đơn trước đó
        foreach ($invoice->invoice_detail as $invoiceDetail) {
            $laptop = Laptop::find($invoiceDetail->laptop_id);
            if ($laptop) {
                $laptop->quantity -= $invoiceDetail->quantity;
                $laptop->save();
            }
        }

        $invoice->user_id = $validatedData['user_id'];
        $invoice->provider_id = $validatedData['provider_id'];
        $invoice->state = $validatedData['state'];
        $invoice->save();

        // Retrieve current order details
        $currentInvoiceDetails = $invoice->invoice_detail->keyBy('laptop_id');

        foreach ($validatedData['laptops'] as $laptopData) {
            $laptopId = $laptopData['laptop_id'];
            $newQuantity = $laptopData['quantity'];
    
            // Check if this laptop exists in the current order details
            if ($currentInvoiceDetails->has($laptopId)) {
                // If exists, update the quantity
                $invoiceDetail = $currentInvoiceDetails[$laptopId];
    
                // Calculate difference in quantity
                $difference = $newQuantity - $invoiceDetail->quantity;
    
                // Update order detail quantity
                $invoiceDetail->quantity = $newQuantity;
                $invoiceDetail->save();
    
                // Update quantity in the warehouse
                $laptop = Laptop::find($laptopId);
                if ($laptop) {
                    $laptop->quantity += $difference;
                    $laptop->save();
                } else {
                    // Handle case where laptop is not found (though it should exist due to validation)
                    // You can add custom error handling logic here if needed
                    // For simplicity, assuming laptop always exists based on validation
                }
            } else {
                // Handle case where laptop does not exist in current order details
                // Create new order detail and deduct quantity from warehouse
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->order_id = $invoice->id;
                $invoiceDetail->laptop_id = $laptopId;
                $invoiceDetail->quantity = $newQuantity;
                $invoiceDetail->save();
    
                // Update quantity in the warehouse
                $laptop = Laptop::find($laptopId);
                if ($laptop) {
                    $laptop->quantity += $newQuantity; // Assuming new order quantity will be deducted
                    $laptop->save();
                } else {
                    // Handle case where laptop is not found (though it should exist due to validation)
                    // You can add custom error handling logic here if needed
                    // For simplicity, assuming laptop always exists based on validation
                }
            }
        }
    
        // Cập nhật số lượng laptop trong đơn hàng dựa trên thông tin từ hidden input
        $newLaptops = json_decode($request->input('hidden_laptops'), true);
        if (!empty($newLaptops)) {
            foreach ($newLaptops as $newLaptop) {
                $laptopId = $newLaptop['id'];
                $quantity = $newLaptop['quantity'];
    
                // Kiểm tra xem laptop này có trong danh sách chi tiết đơn hàng hiện tại không
                if ($currentInvoiceDetails->has($laptopId)) {
                    // Nếu có, cập nhật số lượng
    
                     $orderDetail = $currentInvoiceDetails[$laptopId];
    
                // Calculate difference in quantity
                $difference = $quantity - $invoiceDetail->quantity;
    
                // Update order detail quantity
                $invoiceDetail->quantity = $quantity;
                $invoiceDetail->save();
    
                // Update quantity in the warehouse
                $laptop = Laptop::find($laptopId);
                if ($laptop) {
                    $laptop->quantity += $difference;
                    $laptop->save();
                } else {
                    // Handle case where laptop is not found (though it should exist due to validation)
                    // You can add custom error handling logic here if needed
                    // For simplicity, assuming laptop always exists based on validation
                }
    
                } else {
                    // Nếu laptop không có trong danh sách chi tiết đơn hàng hiện tại, thêm mới
                    $invoiceDetail = new InvoiceDetail();
                    $invoiceDetail->invoice_id = $invoice->id;
                    $invoiceDetail->laptop_id = $laptopId;
                    $invoiceDetail->quantity = $quantity;
    
                    // Lấy giá của laptop nhập và tính tổng giá
                    $laptop = Laptop::find($laptopId);
                    if ($laptop) {
                        $laptop->quantity+=$quantity;
                        $invoiceDetail->price = $laptop['total'];
                        $laptop->save();
                    } else {
                        // Xử lý trường hợp không tìm thấy laptop (mặc dù theo lý thuyết nó nên tồn tại do validate)
                        // Bạn có thể thêm xử lý lỗi tùy chỉnh ở đây nếu cần thiết
                        // Để đơn giản, giả sử laptop luôn tồn tại dựa trên validate
                        $invoiceDetail->price = 0; // Thiết lập giá mặc định hoặc xử lý theo nhu cầu
                    }
    
                    $invoiceDetail->save(); // Lưu chi tiết đơn hàng mới
                }
            }
        }

        return redirect()->route('invoices.index')->with('success', 'Hóa đơn đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Khôi phục lại số lượng của các chi tiết hóa đơn
        foreach ($invoice->invoice_detail as $invoiceDetail) {
            $laptop = Laptop::find($invoiceDetail->laptop_id);
            if ($laptop) {
                $laptop->quantity -= $invoiceDetail->quantity;
                $laptop->save();
            }
        }

        $invoice->delete();
        $invoice->invoice_detail()->delete();

        return redirect()->route('invoices.index')->with('success', 'Hóa đơn đã được xóa thành công!');
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoice.xlsx');
    }}

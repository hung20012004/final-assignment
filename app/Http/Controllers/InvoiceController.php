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
            $query->where('invoice_code', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('provider', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $invoices = $query->paginate(10);

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
        // Nhân viên kho đang tạo đơn
        $currentUser = Auth::user();
        // Tạo mã hóa đơn tự động
        $date = now()->format('Ymd'); // Lấy ngày tháng hiện tại dưới dạng YYYYMMDD
        $count = Invoice::whereDate('created_at', today())->count() + 1; // Đếm số hóa đơn đã được tạo trong ngày và tăng thêm 1
        $invoiceCode = 'HDN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT); // Ghép nối thành mã hóa đơn
          
        $validatedData = $request->validate([
            'provider_id' => 'required|integer|exists:providers,id',
            'state' => 'required|integer',
            'laptops' => 'required|array|min:1',
            'laptops.*.laptop_id' => 'required|integer',
            'laptops.*.quantity' => 'required|integer|min:1',
        ]);
        
        $invoice = new Invoice();
        $invoice->invoice_code = $invoiceCode;
        $invoice->user_id = $currentUser->id;
        $invoice->provider_id = $validatedData['provider_id'];
        $invoice->state = $validatedData['state'];
        $invoice->save();

        foreach ($validatedData['laptops'] as $laptopData) { 
            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->laptop_id = $laptopData['laptop_id'];
            $invoiceDetail->quantity = $laptopData['quantity'];
            $laptop = Laptop::find($laptopData['laptop_id']);
            if ($laptop) {
                $invoiceDetail->price = $laptop->price * $laptopData['quantity'];
            } else {
                $invoiceDetail->price = 0; // Set a defahandle as neededult price or 
            }
            $invoiceDetail->save();
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice added successfully!');
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

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Invoice $invoice)
    // {
    //     $validatedData = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'provider_id' => 'required|exists:providers,id',
    //         'state' => 'nullable|integer',
    //         'laptops' => 'nullable|array|min:1',
    //         'laptops.*.laptop_id' => 'required|exists:laptops,id',
    //         'laptops.*.quantity' => 'required|integer|min:1',
    //     ]);

    //     $invoice->user_id = $validatedData['user_id'];
    //     $invoice->provider_id = $validatedData['provider_id'];
    //     $invoice->state = $validatedData['state'];
    //     $invoice->save();

    //     $invoice->invoice_detail()->delete();
    //     // Iterate through each laptop in the request and create corresponding OrderDetail
    //     foreach ($validatedData['laptops'] as $laptopData) {
    //         $invoiceDetail = new InvoiceDetail();
    //         $invoiceDetail->invoice_id = $invoice->id; // Associate the order detail with the newly created order
    //         $invoiceDetail->laptop_id = $laptopData['laptop_id'];
    //         $invoiceDetail->quantity = $laptopData['quantity'];

    //         // Retrieve the price of the laptop from the database and calculate total price
    //         $laptop = Laptop::find($laptopData['laptop_id']);
    //         if ($laptop) {
    //             $invoiceDetail->price = $laptop->price * $laptopData['quantity'];
    //         } else {
    //             $invoiceDetail->price = 0; // Set a default price or handle as needed
    //         }

    //         $invoiceDetail->save(); // Save the order detail
    //     }
    //     return redirect()->route('invoices.index', $invoice)->with('success', 'Invoice updated successfully!');
    // }
    public function update(Request $request, Invoice $invoice)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:providers,id',
            'state' => 'nullable|integer',
            'invoice_details' => 'nullable|array|min:1',
            'invoice_details.*.laptop_id' => 'required|exists:laptops,id',
            'invoice_details.*.quantity' => 'required|integer|min:1',
            'invoice_details.*.price' => 'required|numeric|min:0', // Ensure price is also validated
        ]);

        $invoice->user_id = $validatedData['user_id'];
        $invoice->provider_id = $validatedData['provider_id'];
        $invoice->state = $validatedData['state'];
        $invoice->save();

        $invoice->invoice_detail()->delete();

        // Iterate through each invoice detail in the request and create corresponding InvoiceDetail
        foreach ($validatedData['invoice_details'] as $invoiceDetailData) {
            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id; // Associate the invoice detail with the invoice
            $invoiceDetail->laptop_id = $invoiceDetailData['laptop_id'];
            $invoiceDetail->quantity = $invoiceDetailData['quantity'];
            $invoiceDetail->price = $invoiceDetailData['price']; // Use the submitted price

            $invoiceDetail->save(); // Save the invoice detail
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
         $invoice->delete();
         $invoice->invoice_detail()->delete();
         return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }
    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoice.xlsx');
    }}

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

class AccountantInvoiceController extends Controller
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

        return view('user.accountant.invoice.index-invoice', compact('invoices'));
    }
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $laptops= Laptop::all();
        $providers = Provider::all();

        return view('user.accountant.invoice.create-invoice', compact('providers','laptops'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        $date = now()->format('Ymd');
        $count = Invoice::whereDate('created_at', today())->count() + 1;
        $invoiceCode = 'HDN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $validatedData = $request->validate([
            'provider_id' => 'required|integer|exists:providers,id',
            'state' => 'required|integer',
            'laptops' => 'required|array|min:1',
            'laptops.*.laptop_id' => 'required|integer|exists:laptops,id',
            'laptops.*.quantity' => 'required|integer|min:1',
        ]);

        $invoice = new Invoice();
        $invoice->invoice_code = $invoiceCode;
        $invoice->user_id = $currentUser->id;
        $invoice->provider_id = $validatedData['provider_id'];
        $invoice->state = $validatedData['state'];
        $invoice->save();

        foreach ($validatedData['laptops'] as $laptopData) {
            $laptop = Laptop::findOrFail($laptopData['laptop_id']);

            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->laptop_id = $laptopData['laptop_id'];
            $invoiceDetail->quantity = $laptopData['quantity'];
            $invoiceDetail->price = $laptop->price * $laptopData['quantity'];
            $invoiceDetail->save();

            $laptop->quantity += $laptopData['quantity'];
            $laptop->save();
        }

        return redirect()->route('accountantInvoices.index')->with('success', 'created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::findOrFail($invoice->id);

        return view('user.accountant.invoice.show-invoice', compact('invoice'));
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

    return view('user.accountant.invoice.edit-invoice', compact('invoice', 'users', 'providers', 'laptops'));
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

        $invoice->invoice_detail()->delete();

        foreach ($validatedData['invoice_details'] as $invoiceDetailData) {
            $laptop = Laptop::findOrFail($invoiceDetailData['laptop_id']);

            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->laptop_id = $invoiceDetailData['laptop_id'];
            $invoiceDetail->quantity = $invoiceDetailData['quantity'];
            $invoiceDetail->price = $invoiceDetailData['price'];
            $invoiceDetail->save();

            $laptop->quantity += $invoiceDetailData['quantity'];
            $laptop->save();
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

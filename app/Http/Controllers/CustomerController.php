<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('user.seller.customer.index-customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.seller.customer.create-customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:10 |unique:customers,phone',
        ] /*, [
            'name.required' => 'Bạn cần nhập tên',
            'email.required' => 'Bạn cần nhập email',
            'email.unique' => 'Email đã tồn tại',
        ]*/);

        $customer = new Customer();
        $customer->name = $validatedData['name'];
        $customer->email = $validatedData['email'];
        $customer->address = $validatedData['address'];
        $customer->phone = $validatedData['phone'];
        $customer->save();

       return redirect()->route('customers.create')
                        ->with('success', 'Customer created successfully!')
                        ->with('redirect', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
         $customer = Customer::findOrFail($customer->id);

        return view('user.seller.customer.show-customer', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
         $customer = Customer::findOrFail($customer->id);

        return view('user.seller.customer.edit-customer', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
         $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:10',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'address' => 'nullable|string|max:255',
        ]);
        
        $customer->update($validatedData);
        return redirect()->route('customers.index', $customer)->with('success', 'Customer information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
         // Xóa người dùng
         $customer->delete();

         // Chuyển hướng người dùng đến trang danh sách người dùng
         return redirect()->route('customers.index')->with('success', 'User deleted successfully!');
    }
}

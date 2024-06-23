<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Laptop;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();    
        if($searchSeller = $request->input('searchSeller'))
        {
            $query->whereHas('user',function($q) use ($searchSeller){
                $q->where('name', 'like', "%$searchSeller%");
            });
        }

        if($searchCustomer = $request->input('searchCustomer'))
        {
            $query->whereHas('customer',function($q) use ($searchCustomer){
                $q->where('name', 'like', "%$searchCustomer%");
            });
        }
        $orders = $query->get();
        // $orders = Order::with(['user', 'customer', 'order_detail.laptop'])->get();
        return view('user.seller.order.index-order', compact( 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'seller')->get();
        $customers = Customer::all();
        $laptops = Laptop::all();
        return view('user.seller.order.create-order', compact('users', 'customers', 'laptops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'user_id' => 'required|integer|max:255',
        'customer_id' => 'required|integer|max:255',
        'state' => 'required|integer|max:255',
        'hidden_laptops' => 'required', // Đây là input ẩn chứa dữ liệu laptops
    ]);

    // Lấy dữ liệu từ hidden-laptops và chuyển đổi thành mảng PHP
    $laptopsData = json_decode($request->input('hidden_laptops'), true);

    // Kiểm tra số lượng laptop trong kho
    foreach ($laptopsData as $laptop) {
        $laptopModel = Laptop::find($laptop['id']);
        if (!$laptopModel || $laptopModel->quantity < $laptop['quantity']) {
            return redirect()->back()->with('error', 'Not enough stock for ' . ($laptopModel ? $laptopModel->name : 'a laptop'));
        }
    }

    // Tạo đơn hàng mới
    $order = new Order();
    $order->user_id = $validatedData['user_id'];
    $order->customer_id = $validatedData['customer_id'];
    $order->state = $validatedData['state'];
    $order->save();

    // Lưu thông tin chi tiết đơn hàng và cập nhật số lượng laptop trong kho
    foreach ($laptopsData as $laptop) {
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id; // Sử dụng ID của đơn hàng mới tạo
        $orderDetail->laptop_id = $laptop['id'];
        $orderDetail->quantity = $laptop['quantity'];
        $orderDetail->price = $laptop['total'];
        $orderDetail->save();

        // Giảm số lượng laptop trong kho
        $laptopModel = Laptop::find($laptop['id']);
        $laptopModel->quantity -= $laptop['quantity'];
        $laptopModel->save();
    }

    // Redirect or return a response
    return redirect()->route('orders.index')->with('success', 'Order created successfully.');
}

 
    public function show(Order $order)
    {
        $order = Order::findOrFail($order->id);
        return view('user.seller.order.show-order', compact('order'));
    }

 
    public function edit(Order $order)
    {
        $order = Order::findOrFail($order->id);
        $customers = Customer::all();
        $users = User::where('role', 'seller')->get();
        $laptops = Laptop::all();

        return view('user.seller.order.edit-order', compact('order', 'users', 'customers', 'laptops'));
    }

 
    public function update(Request $request, Order $order)
    {

         $validatedData = $request->validate([
        'user_id' => 'nullable|integer', // Assuming user_id is the seller's ID
        'customer_id' => 'nullable|integer', // Assuming customer_id is the customer's ID
        'state' => 'nullable|boolean', // Assuming state is a boolean (1 or 0)
        'laptops' => 'nullable|array|min:1', // Require at least one laptop
        'laptops.*.laptop_id' => 'nullable|integer', // Each laptop_id must be an integer
        'laptops.*.quantity' => 'nullable|integer|min:1', // Each quantity must be an integer and at least 1
    ]);

    // Update order details
    $order->user_id = $validatedData['user_id'];
    $order->customer_id = $validatedData['customer_id'];
    $order->state = $validatedData['state'];
    $order->save();

    // Delete existing order details and recreate them
    $order->order_detail()->delete();

    // Create new order details based on validated data
    foreach ($validatedData['laptops'] as $laptopData) {
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id; // Associate the order detail with the order
        $orderDetail->laptop_id = $laptopData['laptop_id'];
        $orderDetail->quantity = $laptopData['quantity'];

        // Retrieve the price of the laptop from the database and calculate total price
        $laptop = Laptop::find($laptopData['laptop_id']);
        if ($laptop) {
            $orderDetail->price = $laptop->price * $laptopData['quantity'];
        } else {
            // Handle case where laptop is not found (though it should exist due to validation)
            // You can add custom error handling logic here if needed
            // For simplicity, assuming laptop always exists based on validation
            $orderDetail->price = 0; // Set a default price or handle as needed
        }

        $orderDetail->save(); // Save the order detail
    }

     $laptopsData1 = json_decode($request->input('hidden_laptops'), true);
        //  dd($laptopsData1);
        if (!empty($laptopsData1)) {
        foreach ($laptopsData1 as $laptop) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id; // Sử dụng ID của đơn hàng mới tạo
            $orderDetail->laptop_id = $laptop['id'];
            $orderDetail->quantity = $laptop['quantity'];
            $orderDetail->price = $laptop['total'];
            $orderDetail->save();
        }}

    return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        $order->order_detail()->delete();
        return redirect()->route('orders.index')->with('success', 'Delete successfully');
    }
    public function statistics()
    {
        // Top-Selling Products
        $topSellingProducts = Laptop::select('laptops.name', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->join('order_details', 'laptops.id', '=', 'order_details.laptop_id')
            ->groupBy('laptops.name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Monthly Sales
        $monthlySales = Order::select(DB::raw('MONTH(orders.created_at) as month'), DB::raw('SUM(order_details.price * order_details.quantity) as total_sales'))
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('month')
            ->get();

        // Customer Purchase Counts
        $customerPurchaseCounts = Customer::select('customers.name', DB::raw('COUNT(orders.id) as total_orders'))
            ->join('orders', 'customers.id', '=', 'orders.customer_id')
            ->groupBy('customers.name')
            ->orderBy('total_orders', 'desc')
            ->get();

        return view('user.manager.statistic-order', compact('topSellingProducts', 'monthlySales', 'customerPurchaseCounts'));
    }

    public function export()
    {
        return Excel::download(new OrdersExport(), 'Orders.xlsx');
    }
}

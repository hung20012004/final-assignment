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
        // Lấy user_id của user hiện tại
        $userId = auth()->user()->id;

        // Thêm điều kiện lọc theo user_id
        $query->where('user_id', $userId); 
         
        if($search = $request->input('search'))
        {
            $query->whereHas('customer',function($q) use ($search){
                $q->where('name', 'like', "%$search%");
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

            // Tạo mảng để chứa các lỗi về số lượng
            $quantityErrors = [];

        // Kiểm tra số lượng laptop trong kho
            foreach ($laptopsData as $laptop) {
                $laptopModel = Laptop::find($laptop['id']);
                if (!$laptopModel || $laptopModel->quantity < $laptop['quantity']) {
                    // Thêm lỗi vào mảng lỗi
                    $quantityErrors[] = 'Not enough stock for ' . ($laptopModel ? $laptopModel->name . ' (Available: ' . $laptopModel->quantity . ')' : 'a laptop');
                }
            }

            // Nếu có lỗi về số lượng, trả về với thông báo lỗi
            if (!empty($quantityErrors)) {
                return redirect()->back()->withErrors(['quantity' => $quantityErrors])->withInput();
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
        'user_id' => 'nullable|integer',
        'customer_id' => 'nullable|integer',
        'state' => 'nullable|boolean',
        'laptops' => 'nullable|array|min:1',
        'laptops.*.laptop_id' => 'nullable|integer',
        'laptops.*.quantity' => 'nullable|integer|min:1',
    ]);

    // Retrieve current order details
    $currentOrderDetails = $order->order_detail->keyBy('laptop_id');

    // Tạo mảng để chứa các lỗi về số lượng
    $quantityErrors = [];

    // Kiểm tra số lượng laptop trong kho cho tất cả các laptop
    foreach ($validatedData['laptops'] as $laptopData) {
        $laptopId = $laptopData['laptop_id'];
        $newQuantity = $laptopData['quantity'];

        // Lấy model laptop hiện tại
        $laptopModel = Laptop::find($laptopId);

        // Kiểm tra nếu laptop không tồn tại hoặc số lượng không đủ
        if ($laptopModel) {
            $availableQuantity = $laptopModel->quantity;

            if ($currentOrderDetails->has($laptopId)) {
                // Nếu laptop đã có trong đơn hàng, tính toán sự khác biệt
                $currentQuantity = $currentOrderDetails[$laptopId]->quantity;
                $difference = $newQuantity - $currentQuantity;

                if ($difference > 0 && $availableQuantity < $difference) {
                    $quantityErrors[] = 'Not enough stock for ' . $laptopModel->name . ' (Available: ' . $availableQuantity . ')';
                }
            } else {
                // Nếu là laptop mới, kiểm tra số lượng mới so với tồn kho
                if ($availableQuantity < $newQuantity) {
                    $quantityErrors[] = 'Not enough stock for ' . $laptopModel->name . ' (Available: ' . $availableQuantity . ')';
                }
            }
        } else {
            $quantityErrors[] = 'Laptop with ID ' . $laptopId . ' does not exist.';
        }
    }

    // Nếu có lỗi về số lượng, trả về với thông báo lỗi
    if (!empty($quantityErrors)) {
        return redirect()->back()->withErrors(['quantity' => $quantityErrors])->withInput();
    }

    // Update order information
    $order->user_id = $validatedData['user_id'];
    $order->customer_id = $validatedData['customer_id'];
    $order->state = $validatedData['state'];
    $order->save();

    // Iterate through each laptop sent from the form
    foreach ($validatedData['laptops'] as $laptopData) {
        $laptopId = $laptopData['laptop_id'];
        $newQuantity = $laptopData['quantity'];

        // Check if this laptop exists in the current order details
        if ($currentOrderDetails->has($laptopId)) {
            // If exists, update the quantity
            $orderDetail = $currentOrderDetails[$laptopId];

            // Calculate difference in quantity
            $difference = $newQuantity - $orderDetail->quantity;

            // Update order detail quantity
            $orderDetail->quantity = $newQuantity;
            $orderDetail->save();

            // Update quantity in the warehouse
            $laptop = Laptop::find($laptopId);
            if ($laptop) {
                $laptop->quantity -= $difference;
                $laptop->save();
            }
        } else {
            // Handle case where laptop does not exist in current order details
            // Create new order detail and deduct quantity from warehouse
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->laptop_id = $laptopId;
            $orderDetail->quantity = $newQuantity;
            $orderDetail->save();

            // Update quantity in the warehouse
            $laptop = Laptop::find($laptopId);
            if ($laptop) {
                $laptop->quantity -= $newQuantity; // Assuming new order quantity will be deducted
                $laptop->save();
            }
        }
    }



    // Cập nhật số lượng laptop trong đơn hàng dựa trên thông tin từ hidden input
    $newLaptops = json_decode($request->input('hidden_laptops'), true);

     if (!empty($newLaptops)) {
        foreach ($newLaptops as $newLaptop) {
            $laptopId = $newLaptop['id']; // số lượng lấy từ bảng
            $newQuantity = $newLaptop['quantity'];

            // Lấy model laptop hiện tại
            $laptopModel = Laptop::find($laptopId);

            if ($laptopModel) {
                $availableQuantity = $laptopModel->quantity;

                if ($currentOrderDetails->has($laptopId)) {
                    // Nếu laptop đã có trong đơn hàng, tính toán sự khác biệt
                    $currentQuantity = $currentOrderDetails[$laptopId]->quantity;
                    $difference = $newQuantity - $currentQuantity;

                    if ($difference > 0 && $availableQuantity < $difference) {
                        $quantityErrors[] = 'Not enough stock for ' . $laptopModel->name . ' (Available: ' . $availableQuantity . ')';
                    }
                } else {
                    // Nếu là laptop mới, kiểm tra số lượng mới so với tồn kho
                    if ($availableQuantity < $newQuantity) {
                        $quantityErrors[] = 'Not enough stock for ' . $laptopModel->name . ' (Available: ' . $availableQuantity . ')';
                    }
                }
            } else {
                $quantityErrors[] = 'Laptop with ID ' . $laptopId . ' does not exist.';
            }
        }
    }

    // Nếu có lỗi về số lượng, trả về với thông báo lỗi
    if (!empty($quantityErrors)) {
        return redirect()->back()->withErrors(['quantity' => $quantityErrors])->withInput();
    }

    // Update order information
    $order->user_id = $validatedData['user_id'];
    $order->customer_id = $validatedData['customer_id'];
    $order->state = $validatedData['state'];
    $order->save();

    // Iterate through each laptop sent from the form
    if(is_array($newLaptops)){
         foreach ($newLaptops as $newLaptop) {
        $laptopId = $newLaptop['id'];
        $quantity = $newLaptop['quantity'];

        // Check if this laptop exists in the current order details
        if ($currentOrderDetails->has($laptopId)) {
            // If exists, update the quantity
            $orderDetail = $currentOrderDetails[$laptopId];

            // Calculate difference in quantity
            $difference = $quantity - $orderDetail->quantity;

            // Update order detail quantity
            $orderDetail->quantity = $quantity;
            $orderDetail->save();

            // Update quantity in the warehouse
            $laptop = Laptop::find($laptopId);
            if ($laptop) {
                $laptop->quantity -= $difference;
                $laptop->save();
            }
        } else {
            // If laptop does not exist in current order details, add new
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->laptop_id = $laptopId;
            $orderDetail->quantity = $quantity;

            // Lấy giá của laptop từ cơ sở dữ liệu và tính tổng giá
            $laptop = Laptop::find($laptopId);
            if ($laptop) {
                $laptop->quantity -= $quantity;
                $orderDetail->price = $laptop->price * $quantity;
                $laptop->save();
            } else {
                $orderDetail->price = 0;
            }

            $orderDetail->save();
        }
    }
    }


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

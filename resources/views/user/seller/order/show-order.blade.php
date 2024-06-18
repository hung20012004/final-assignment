<x-app-layout>
    @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
    <div class="container">
        <h1>Order Information</h1>
        <div>
            <p><strong>ID:</strong> {{ $order->id }}</p>
            <p><strong>Seller name:</strong> {{ $order->user->name }}</p>
            <p><strong>Customer name:</strong> {{ $order->customer->name }}</p>
            <p><strong>Order Time:</strong> {{ $order->created_at->format('d-m-Y H:i:s')  }}</p>
            <table class="table table-bordered mt-2">
                  <thead style="background-color: #d3d8dc;">
                    <tr>
                        <th>Laptop name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>State</th>
                        <th>Sum</th>
                    </tr>
                  </thead>
                       <tbody>
                    @php
                        $total = 0; // Khởi tạo biến tổng tiền
                    @endphp

                    @foreach ($order->order_detail as $orderDetail)
                        <tr>
                            <td>{{ $orderDetail->laptop->name }}</td>
                            <td>{{ $orderDetail->quantity }}</td>
                            <td>{{ number_format($orderDetail->laptop->price, 0, ',', '.') }} </td>
                            <td>{{ $order->state == 1 ? 'Đã xử lý' : 'Chưa xử lý' }}</td>
                            <td>{{  number_format($orderDetail->quantity * $orderDetail->laptop->price, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $total += $orderDetail->quantity * $orderDetail->laptop->price; // Cộng vào tổng tiền
                            // Update total to order_detail
                            $orderDetail->price = $total;
                        @endphp
                    @endforeach

                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>{{ number_format($total, 0, ',', '.') }} đ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

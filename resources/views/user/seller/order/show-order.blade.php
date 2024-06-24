<x-app-layout>
<div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('orders.index'), 'label' => 'Orderrs'],
                    ['url' => route('orders.show', $order->id), 'label' => 'Show Order'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Show Order</h5>
                    </div>
                   <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>ID:</strong> {{ $order->id }}
                            </li>
                            <li class="list-group-item">
                              <strong>Seller name:</strong> {{ Auth::user()->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Customer name:</strong> {{ $order->customer->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Order Time:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y')}}
                            </li>
                            <!-- Add any other fields you want to display here -->
                        </ul>
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
                                        $groupedItems = collect();
                                    @endphp

                                    @foreach ($order->order_detail as $orderDetail)
                                        @php
                                            $key = $orderDetail->laptop->id;
                                            if (!$groupedItems->has($key)) {
                                                $groupedItems->put($key, (object)[
                                                    'name' => $orderDetail->laptop->name,
                                                    'quantity' => 0,
                                                    'price' => $orderDetail->laptop->price,
                                                ]);
                                            }
                                            $groupedItems[$key]->quantity += $orderDetail->quantity;
                                            $total += $orderDetail->quantity * $orderDetail->laptop->price;
                                        @endphp
                                    @endforeach

                                    @foreach ($groupedItems as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($order->state == 0)
                                                    Cancel
                                                @elseif ($order->state == 1)
                                                    Undischarged
                                                @else
                                                    Discharged
                                                @endif
                                            </td>
                                            <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach

                            {{-- $total += $orderDetail->quantity * $orderDetail->laptop->price; // Cộng vào tổng tiền
                            // Update total to order_detail
                            $orderDetail->price = $total; --}}


                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>{{ number_format($total, 0, ',', '.') }} đ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>

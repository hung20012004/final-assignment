<x-app-layout>
    <div class="container">
        <h1>Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Add New Order</a>
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Seller Name</th>
                    <th>Customer Name</th>
                    <th>Order Time</th>
                    <th>State</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name}}</td>
                        <td>{{ $order->customer->name}}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $order->state == 1 ? 'Đã xử lý' : 'Chưa xử lý' }}</td>
                          {{-- @if ($order->order_detail)
                    @else
                    <td colspan="3">Chi tiết đơn hàng không tồn tại</td>
                    @endif --}}
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-info">View</a>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Edit</a>
                            
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteOrder())">
                                @csrf
                                @method('DELETE')
                                <button data-id="{{ $order->id }}" type="submit" class="btn btn-danger btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

<script type="text/javascript">
    function deleteOrder() {
        return confirm('Bạn có chắc chắn muốn xóa ?');
    };
</script>
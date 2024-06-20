<x-app-layout>
    <div class="container-fluid">
        <h1>Orders</h1>
         <div class="container col-md-12 col-lg-11 col-sm-auto px-md-3 p-3 bg-white shadow-sm mb-5 rounded mx-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('orders.export') }}" class="btn btn-success">Excel</a>
                </div>
                <form action="{{ route('orders.index') }}" method="GET" class="form-inline">
                    <input class="form-control mr-sm-2" type="searchSeller" name="searchSeller" placeholder="Search Seller" aria-label="Search">
                    <input class="form-control mr-sm-2" type="searchCustomer" name="searchCustomer" placeholder="Search  Customer" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
        
            </div>
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table id="dataid" class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Seller Name</th>
                    <th>Customer Name</th>
                    <th>Order Time</th>
                    <th>State</th>
                    <th>Actions</th>
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
    </div>
</div>
<script type="text/javascript">

    function deleteOrder() {
        return confirm('Bạn có chắc chắn muốn xóa ?');
    };

     $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });

</script>
</x-app-layout>

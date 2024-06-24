<x-app-layout>
  <div class="container">
         <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('orders.index'), 'label' => 'Orders'],
                ]" />
            </div>    
            {{-- Dùng x-breadcum để tạo MẢNG chứa các link, mỗi link có url và nhãn tương ỨNG --}}
        </div>
        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Orders Management</h5>
                            <div>
                                <a href="{{ route('orders.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('orders.export') }}" class="btn btn-success">Excel</a>
                                 </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                    <form action="{{ route('orders.index') }}" method="GET" class="mb-3"> 
                         {{-- // Tìm kiếm qua thẻ form  và kiểu get để lấy dữ liệu --}}
                     <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> 
                                    {{-- Để type submit  --}}
                                </div>
                     </div>
                </form>
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
                {{-- orders lấy từ compact --}}
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ $order->customer->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y')}}</td>
                        <td>
                            @if ($order->state == 0)
                                Cancel
                            @elseif ($order->state == 1)
                                Undischarged
                            @else
                                Discharged
                            @endif
                        </td>
                          {{-- @if ($order->order_detail)
                    @else
                    <td colspan="3">Chi tiết đơn hàng không tồn tại</td>
                    @endif --}}
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-info">View</a> 
                             {{-- phải truyền biến order để tí fill dữ liệu lên --}}
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Edit</a>
                            
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteOrder())"> 
                                {{-- onsubmit dùng khi nào click vào nút submit --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
  </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">

    function deleteOrder() {
        return confirm('Bạn có chắc chắn muốn xóa ?');
        // xác nhận có muốn xóa k
    };

     $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });


</script>
</x-app-layout>

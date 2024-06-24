<x-app-layout>
  <div class="container">
         <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('salary.index'), 'label' => 'Salaries'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Salary Management</h5>
                            <div>
                                <a href="{{ route('salary.create') }}" class="btn btn-primary">New</a>
                                <button class="btn btn-success" data-toggle="modal" data-target="#exportModal">Excel</button>
                                 </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                     <form action="{{ route('salary.index') }}" method="GET" class="mb-3">
                     <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                     </div>
                </form>
        <div class="table-responsive">
            <table id="dataid" class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Staff</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Total</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salary as $key => $salaryindex)
                    <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $salaryindex->user->name }}</td>
                                <td>{{ $salaryindex->month }}</td>
                                <td>{{ $salaryindex->year }}</td>
                                <td>{{ number_format($salaryindex->total_salary, 0, ',', '.') }}</td>
                                <td>{{  \Carbon\Carbon::parse($salaryindex->created_at)->format('H:i d/m/Y')}}</td>
                          {{-- @if ($order->order_detail)
                    @else
                    <td colspan="3">Chi tiết đơn hàng không tồn tại</td>
                    @endif --}}
                        <td>
                            <a href="{{ route('salary.show', $salaryindex) }}" class="btn btn-info">View</a>
                            <a href="{{ route('salary.edit', $salaryindex) }}" class="btn btn-warning">Edit</a>

                            <form action="{{ route('salary.destroy', $salaryindex) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteOrder())">
                                @csrf
                                @method('DELETE')
                                <button data-id="{{ $salaryindex->id }}" type="submit" class="btn btn-danger btn-delete">Delete</button>
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

    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Salary Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('salary.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="monthexport">Month</label>
                            <select name="monthexport" id="monthexport" class="form-control" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Năm</label>
                            <select name="yearexport" id="yearexport" class="form-control" required>
                                @for ($y = date('Y') - 10; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">

    function deleteOrder() {
        return confirm('Bạn có chắc chắn muốn xóa?');
    };

     $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });

</script>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Invoice Management</h5>
                            <div>
                                <a href="{{ route('invoices.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('invoices.export') }}" class="btn btn-success">Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('invoices.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="dataid" class="table table-bordered mt-3">
                                <thead class="bg-light text-black text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Invoice Code</th>
                                        <th>Staff Name</th>
                                        <th>Provider Name</th>
                                        <th>State</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class="text-center">{{ $invoice->id }}</td>
                                            <td>{{ $invoice->invoice_code }}</td>
                                            <td>{{ $invoice->user->name }}</td>
                                            <td>{{ $invoice->provider->name }}</td>
                                            <td class="text-center">
                                                @if($invoice->state == 2)
                                                    Đã xử lý
                                                @elseif($invoice->state == 1)
                                                    Đang xử lý
                                                @else
                                                    Đã hủy
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm mx-2">View</a>
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $invoice->id }}', '{{ $invoice->invoice_code }}')">Delete</button>
                                                <form id="delete-form-{{ $invoice->id }}" action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
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
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip',
                // Add additional DataTables configuration options if needed
            });
        });
        // Function xác nhận xóa
        function confirmDelete(id, code) {
            if (confirm(`Bạn có chắc muốn xóa hóa đơn với mã "${code}" không?`)) {
                // Nếu xác nhận xóa, submit form xóa tương ứng
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('laptops.index'), 'label' => 'Laptops'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Laptop Management</h5>
                            <div>
                                <a href="{{ route('laptops.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('laptops.export') }}" class="btn btn-success">Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('laptops.index') }}" method="GET" class="mb-3">
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
                                        <th>Name</th>
                                        <th>Manufactory</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laptops as $laptop)
                                        <tr>
                                            <td class="text-center">{{ $laptop->id }}</td>
                                            <td>{{ $laptop->name }}</td>
                                            <td>{{ $laptop->manufactory->name }}</td>
                                            <td>{{ $laptop->category->name }}</td>
                                            <td>{{ number_format($laptop->price, 0, ',', '.') }} VND</td>
                                            <td>{{ $laptop->quantity }}</td>
                                            <td class="text-center">{{ ucfirst($laptop->status) }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('laptops.show', $laptop) }}" class="btn btn-info btn-sm mx-2">View</a>
                                                <a href="{{ route('laptops.edit', $laptop) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                                <!-- Xóa với popup xác nhận -->
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $laptop->id }}', '{{ $laptop->name }}')">Delete</button>

                                                <!-- Form xóa -->
                                                <form id="delete-form-{{ $laptop->id }}" action="{{ route('laptops.destroy', $laptop) }}" method="POST" style="display: none;">
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
        function confirmDelete(id, name) {
            if (confirm(`Bạn có chắc muốn xóa laptop "${name}" không?`)) {
                // Nếu xác nhận xóa, submit form xóa tương ứng
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

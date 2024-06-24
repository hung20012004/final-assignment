<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('manufactories.index'), 'label' => 'Manufactories'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Manufactory Management</h5>
                            <div>
                                <a href="{{ route('manufactories.create') }}" class="btn btn-primary">New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('manufactories.index') }}" method="GET" class="mb-3">
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
                                        <th>Address</th>
                                        <th>Website</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($manufactories as $manufactory)
                                        <tr>
                                            <td>{{ $manufactory->id }}</td>
                                            <td>{{ $manufactory->name }}</td>
                                            <td>{{ $manufactory->address }}</td>
                                            <td>{{ $manufactory->website }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('manufactories.edit', $manufactory) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                                <!-- Xóa với popup xác nhận -->
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $manufactory->id }}', '{{ $manufactory->name }}')">Delete</button>

                                                <!-- Form xóa -->
                                                <form id="delete-form-{{ $manufactory->id }}" action="{{ route('manufactories.destroy', $manufactory) }}" method="POST" style="display: none;">
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
            if (confirm(`Are you sure you want to delete this task?`)) {
                // Nếu xác nhận xóa, submit form xóa tương ứng
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

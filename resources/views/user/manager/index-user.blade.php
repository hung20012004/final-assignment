<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('users.index'), 'label' => 'Users'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">User Management</h5>
                            <div>
                                <a href="{{ route('users.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('users.export') }}" class="btn btn-success">Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('users.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="users-table" class="table table-bordered mt-3">
                                <thead class="bg-light text-black text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm mx-2">View</a>
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirmDelete();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mx-2">Delete</button>
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
            $('#users-table').DataTable({
                dom: 'rtip',
                // Add additional DataTables configuration options if needed
            });
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this user?');
        }
    </script>
</x-app-layout>

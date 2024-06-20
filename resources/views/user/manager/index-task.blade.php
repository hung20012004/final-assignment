<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('tasks.index'), 'label' => 'Tasks'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Task Management</h5>
                            <div>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('tasks.export') }}" class="btn btn-success">Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('tasks.index') }}" method="GET" class="mb-3">
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
                                        <th>Assigned Staff</th>
                                        <th>Created At</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td class="text-center">{{ $task->id }}</td>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->created_at)->format('H:i d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->time)->format('H:i d/m/Y') }}</td>
                                            <td class="text-center">{{ ucfirst($task->state) }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm mx-2">View</a>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline-block;">
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
            $('#dataid').DataTable({
                dom: 'rtip',
                // Add additional DataTables configuration options if needed
            });
        });
    </script>
</x-app-layout>

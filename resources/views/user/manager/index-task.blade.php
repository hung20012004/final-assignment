<x-app-layout>
    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('tasks.index'), 'label' => 'Tasks'],
            ]" />
        </div>
        <div class="container col-md-12 col-lg-11 col-sm-auto px-md-3 p-3 bg-white shadow-sm mb-5 rounded mx-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('tasks.export') }}" class="btn btn-success">Excel</a>
                </div>
                <form action="{{ route('tasks.index') }}" method="GET" class="form-inline">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="dataid" class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Staff</th>
                            <th>Created at</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->user->name }}</td>
                                <td>{{ $task->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $task->time }}</td>
                                <td>{{ $task->state }}</td>
                                <td>
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });
    </script>
</x-app-layout>

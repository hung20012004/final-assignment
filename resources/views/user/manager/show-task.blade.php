<x-app-layout>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('tasks.index'), 'label' => 'Tasks'],
                    ['url' => '', 'label' => 'Task Details'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Task Details</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>ID:</strong> {{ $task->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Name:</strong> {{ $task->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Description:</strong> {{ $task->description }}
                            </li>
                            <li class="list-group-item">
                                <strong>State:</strong> {{ ucfirst($task->state) }}
                            </li>
                            <li class="list-group-item">
                                <strong>Assigned to User:</strong> {{ $task->user->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Deadline:</strong> {{ $task->time }}
                            </li>
                            <!-- Add any other fields you want to display here -->
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

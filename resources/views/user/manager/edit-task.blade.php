<x-app-layout>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('tasks.index'), 'label' => 'Tasks'],
                    ['url' => route('tasks.edit', $task->id), 'label' => 'Edit Task'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Task</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" class="form-control" required>{{ $task->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="state">State:</label>
                                <select name="state" id="state" class="form-control" required>
                                    <option value="complete" {{ $task->state == 'complete' ? 'selected' : '' }}>Complete</option>
                                    <option value="miss" {{ $task->state == 'miss' ? 'selected' : '' }}>Miss</option>
                                    <option value="incomplete" {{ $task->state == 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Assign to:</label>
                                <option value="">--- Select staff ---</option>
                                <input type="text" class="form-control" value="{{ $task->user->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ $task->user_id }}">
                            </div>
                            <div class="form-group">
                                <label for="time">Deadline:</label>
                                <input type="datetime-local" name="time" id="time" class="form-control" value="{{ $task->time }}" required>
                            </div>


                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

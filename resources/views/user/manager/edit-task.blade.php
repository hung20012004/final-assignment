<x-app-layout>
    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('tasks.index'), 'label' => 'Tasks'],
                ['url' => route('tasks.edit', $task->id), 'label' => 'Edit Task'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
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
                                <option value="uncomplete" {{ $task->state == 'uncomplete' ? 'selected' : '' }}>Uncomplete</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Assign to User:</label>
                            <input type="text" class="form-control" value="{{ $task->user->name }}" readonly>
                            <input type="hidden" name="user_id" value="{{ $task->user_id }}">
                        </div>
                        <div class="form-group">
                            <label for="time">Deadline:</label>
                            <input type="datetime-local" name="time" id="time" class="form-control" value="{{ $task->time }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('usertasks.index'), 'label' => 'Tasks'],
                    ['url' => route('usertasks.edit', $task->id), 'label' => 'Edit Task'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Task</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usertasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="state">State:</label>
                                <select name="state" id="state" class="form-control" required>
                                    <option value="miss" {{ $task->state == 'miss' ? 'selected' : '' }}>Miss</option>
                                    <option value="complete" {{ $task->state == 'complete' ? 'selected' : '' }}>Complete</option>
                                    <option value="incomplete" {{ $task->state == 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                                </select>
                            </div>

                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('usertasks.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

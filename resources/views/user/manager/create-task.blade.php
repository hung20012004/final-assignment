<x-app-layout>

    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('tasks.index'), 'label' => 'Tasks'],
                ['url' => route('tasks.create'), 'label' => 'Create Task'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Staff:</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">--- Select staff ---</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="time">Deadline:</label>
                            <input type="datetime-local" name="time" id="time" class="form-control" required>
                        </div>
                        <input type="hidden" name="state" value="incomplete">
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

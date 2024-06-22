<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('manufactories.index'), 'label' => 'Manufactories'],
                    ['url' => route('manufactories.edit', $manufactory->id), 'label' => 'Edit Manufactory'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Manufactory</h5>
                    </div>
                    <div class="card-body">
                        <form id="editManufactoryForm" action="{{ route('manufactories.update', $manufactory->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $manufactory->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" class="form-control" required>{{ $manufactory->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="start_at">Start At:</label>
                                <input type="date" name="start_at" id="start_at" class="form-control" value="{{ $manufactory->start_at }}" required>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('manufactories.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

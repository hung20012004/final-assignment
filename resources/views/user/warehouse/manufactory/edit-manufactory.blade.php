<x-app-layout>
    <div class="container-fluid">
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
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ $manufactory->address }}" required>
                            </div>
                            <div class="form-group">
                                <label for="website">Website:</label>
                                <input type="url" name="website" id="website" class="form-control" value="{{ $manufactory->website }}">
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

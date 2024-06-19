<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('users.index'), 'label' => 'Users'],
                    ['url' => route('users.edit', $user->id), 'label' => 'Edit User'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="warehouse" {{ $user->role == 'warehouse' ? 'selected' : '' }}>Warehouse staff</option>
                                    <option value="accountant" {{ $user->role == 'accountant' ? 'selected' : '' }}>Accountant</option>
                                    <option value="customer-service" {{ $user->role == 'customer-service' ? 'selected' : '' }}>Customer service staff</option>
                                </select>
                            </div>
                            <!-- Add any other fields required for the user -->

                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

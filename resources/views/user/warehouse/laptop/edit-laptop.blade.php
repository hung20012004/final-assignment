<x-app-layout>

    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('laptops.index'), 'label' => 'Laptops'],
                    ['url' => route('laptops.edit', $laptop->id), 'label' => 'Edit Laptop'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Laptop</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laptops.update', $laptop->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $laptop->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="manufactory_id">Manufactory:</label>
                                <select name="manufactory_id" id="manufactory_id" class="form-control" required>
                                    @foreach ($manufactories as $manufactory)
                                        <option value="{{ $manufactory->id }}" {{ $laptop->manufactory_id == $manufactory->id ? 'selected' : '' }}>
                                            {{ $manufactory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $laptop->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="text" name="price" id="price" class="form-control" value="{{ $laptop->price }}" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $laptop->quantity }}" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Còn hàng" {{ $laptop->status == 'Còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                                    <option value="Hết hàng" {{ $laptop->status == 'Hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                                    <option value="Ngừng kinh doanh" {{ $laptop->status == 'Ngừng kinh doanh' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('laptops.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('laptops.index'), 'label' => 'Laptops'],
                ['url' => route('laptops.edit', $laptop), 'label' => 'Edit Laptop'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    <form action="{{ route('laptops.update', $laptop) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $laptop->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $laptop->price) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $laptop->quantity) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control">
                                @if ($laptop->status == 'In stock')
                                    <option value="In stock" {{ $laptop->status == 'In stock' ? 'selected' : '' }}>Continued</option>
                                @endif
                                @if ($laptop->status == 'Out of stock')
                                    <option value="Out of stock" {{ $laptop->status == 'Out of stock' ? 'selected' : '' }}>Continued</option>
                                @endif
                                <option value="Discontinued" {{ $laptop->status == 'Discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manufactory_id">Manufactory:</label>
                            <select name="manufactory_id" id="manufactory_id" class="form-control" required>
                                @foreach($manufactories as $manufactory)
                                    <option value="{{ $manufactory->id }}" {{ $laptop->manufactory_id == $manufactory->id ? 'selected' : '' }}>{{ $manufactory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $laptop->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="CPU">CPU:</label>
                            <input type="text" name="CPU" id="CPU" class="form-control" value="{{ old('CPU', $laptop->CPU) }}">
                        </div>
                        <div class="form-group">
                            <label for="VGA">VGA:</label>
                            <input type="text" name="VGA" id="VGA" class="form-control" value="{{ old('VGA', $laptop->VGA) }}">
                        </div>
                        <div class="form-group">
                            <label for="RAM">RAM:</label>
                            <input type="text" name="RAM" id="RAM" class="form-control" value="{{ old('RAM', $laptop->RAM) }}">
                        </div>
                        <div class="form-group">
                            <label for="hard_drive">Hard Drive:</label>
                            <input type="text" name="hard_drive" id="hard_drive" class="form-control" value="{{ old('hard_drive', $laptop->hard_drive) }}">
                        </div>
                        <div class="form-group">
                            <label for="display">Display:</label>
                            <input type="text" name="display" id="display" class="form-control" value="{{ old('display', $laptop->display) }}">
                        </div>
                        <div class="form-group">
                            <label for="battery">Battery:</label>
                            <input type="text" name="battery" id="battery" class="form-control" value="{{ old('battery', $laptop->battery) }}">
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight', $laptop->weight) }}">
                        </div>
                        <div class="form-group">
                            <label for="material">Material:</label>
                            <input type="text" name="material" id="material" class="form-control" value="{{ old('material', $laptop->material) }}">
                        </div>
                        <div class="form-group">
                            <label for="OS">OS:</label>
                            <input type="text" name="OS" id="OS" class="form-control" value="{{ old('OS', $laptop->OS) }}">
                        </div>
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <input type="text" name="size" id="size" class="form-control" value="{{ old('size', $laptop->size) }}">
                        </div>
                        <div class="form-group">
                            <label for="ports">Ports:</label>
                            <input type="text" name="ports" id="ports" class="form-control" value="{{ old('ports', $laptop->ports) }}">
                        </div>
                        <div class="form-group">
                            <label for="keyboard">Keyboard:</label>
                            <input type="text" name="keyboard" id="keyboard" class="form-control" value="{{ old('keyboard', $laptop->keyboard) }}">
                        </div>
                        <div class="form-group">
                            <label for="audio">Audio:</label>
                            <input type="text" name="audio" id="audio" class="form-control" value="{{ old('audio', $laptop->audio) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Laptop</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

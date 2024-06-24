<x-app-layout>
    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('laptops.index'), 'label' => 'Laptops'],
                ['url' => route('laptops.create'), 'label' => 'Create Laptop'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    <form action="{{ route('laptops.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Laptop Name" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="price">Price:</label>
                                <input type="number" min="0" name="price" id="price" class="form-control" placeholder="VND" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="quantity">Quantity:</label>
                                <input type="number" min="0" name="quantity" id="quantity" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manufactory_id">Manufactory:</label>
                            <select name="manufactory_id" id="manufactory_id" class="form-control" required>
                                @foreach($manufactories as $manufactory)
                                    <option value="{{ $manufactory->id }}">{{ $manufactory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="CPU">CPU:</label>
                            <input type="text" name="CPU" id="CPU" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="VGA">VGA:</label>
                            <input type="text" name="VGA" id="VGA" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="RAM">RAM:</label>
                            <input type="text" name="RAM" id="RAM" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="hard_drive">Hard Drive:</label>
                            <input type="text" name="hard_drive" id="hard_drive" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="display">Display:</label>
                            <input type="text" name="display" id="display" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="battery">Battery:</label>
                            <input type="text" name="battery" id="battery" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight:</label>
                            <input type="number" name="weight" id="weight" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="material">Material:</label>
                            <input type="text" name="material" id="material" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="OS">OS:</label>
                            <input type="text" name="OS" id="OS" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <input type="text" name="size" id="size" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ports">Ports:</label>
                            <input type="text" name="ports" id="ports" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="keyboard">Keyboard:</label>
                            <input type="text" name="keyboard" id="keyboard" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="audio">Audio:</label>
                            <input type="text" name="audio" id="audio" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Create Laptop</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

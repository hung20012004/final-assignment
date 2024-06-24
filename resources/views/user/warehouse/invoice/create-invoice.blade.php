<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                    ['url' => route('invoices.create'), 'label' => 'Create Invoice'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf
                            <div class="form-group col-md-4">
                                <label for="provider_id">Provider Name:</label>
                                <select name="provider_id" id="provider_id" class="form-control" required>
                                    <option value="">--- Choose provider ---</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="laptop-container" class="form-row">
                                <div class="form-group col-md-4 laptop-item">
                                    <label for="laptop_id">Laptop:</label>
                                    <select name="laptops[0][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" required>
                                        <option value="">--- Choose laptop ---</option>
                                        @foreach ($laptops as $laptop)
                                            <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old('laptops.0.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4 laptop-item">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" name="laptops[0][quantity]" min="1" class="form-control quantity-input" value="{{ old('laptops.0.quantity') }}" oninput="updateTotalPrice()" required>
                                </div>
                                <div class="remove-button-container form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeLaptop(this)">Remove</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="state"><strong>State:</strong></label>
                                    <select name="state" id="state" class="form-control" required>
                                    <option value="1">Đang xử lí</option>
                                    <option value="0">Chưa xử lí</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="total"><strong>Total:</strong></label>
                                    <label id="total" name="total" class="form-control" style="text-align: center; background-color: #e6ffff">0</label>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
                                <button type="button" class="btn btn-success" onclick="addLaptop()">Add Another Laptop</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function addLaptop() {
        const LaptopsContainer = document.getElementById('laptop-container');
        const Laptops = LaptopsContainer.querySelectorAll('.laptop-item');
        const newIndex = Laptops.length;

        const newLaptopItem = document.createElement('div');
        newLaptopItem.classList.add('form-row', 'laptop-item');
        newLaptopItem.setAttribute('data-index', newIndex);

        newLaptopItem.innerHTML = `
            <div class="form-group col-md-4 laptop-item">
                <label for="laptop_id[${newIndex}]">Laptop:</label>
                <select name="laptops[${newIndex}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" required>
                    <option value="">--- Choose laptop ---</option>
                    @foreach ($laptops as $laptop)
                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 laptop-item">
                <label for="quantity[${newIndex}]">Quantity:</label>
                <input type="number" name="laptops[${newIndex}][quantity]" min="1" class="form-control quantity-input" value="" oninput="updateTotalPrice()" required>
            </div>
            <div class="remove-button-container form-group col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger" onclick="removeLaptop(this)">Remove</button>
            </div>
        `;

        LaptopsContainer.appendChild(newLaptopItem);
        updateTotalPrice();
    }


    function removeLaptop(button) {
        const LaptopItem = button.closest('.laptop-item');

        if (LaptopItem) {
            LaptopItem.remove();
            updateTotalPrice();
        }
    }

    function updateTotalPrice() {
        var laptopSelects = document.querySelectorAll('.laptop-select');
        var quantityInputs = document.querySelectorAll('.quantity-input');
        var totalLabel = document.getElementById('total');
        var total = 0;

        laptopSelects.forEach((laptopSelect, index) => {
            var selectedLaptop = laptopSelect.options[laptopSelect.selectedIndex];
            var price = parseFloat(selectedLaptop.getAttribute('data-price')) || 0;
            var quantity = parseFloat(quantityInputs[index].value) || 0;
            total += price * quantity;
        });

        totalLabel.textContent = formatCurrency(total);
    }

    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }
</script>

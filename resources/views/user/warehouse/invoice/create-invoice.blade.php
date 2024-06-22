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
                        <h5 class="card-title mb-0">Edit Invoice</h5>
                    </div>
                <div class="card_body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="form-group col-md-4">
                            <label for="provider_id">Provider Name:</label>
                            <select name="provider_id" id="provider_id" class="form-control" value="" requided>
                                <option value="">--- Chọn nhà cung cấp ---</option>
                                @foreach ($providers as $key => $provider)
                                    <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="laptop-container" class="form-row" style="padding: 0px 0px 0px 15px;">
                            <div class="form-group col-md-4 laptop-item">
                                <label for="laptop_id">Laptop:</label>
                                <select name="laptops[0][laptop_id]" class="form-control laptop-select " onchange="updateTotalPrice()" requided >
                                    <option value="">--- Chọn laptop ---</option>
                                    @foreach ($laptops as $laptop)
                                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old('laptops.0.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 laptop-item">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="laptops[0][quantity]" min="1" class="form-control quantity-input" value="{{ old('laptops.0.quantity') }}" oninput="updateTotalPrice()" requided>
                            </div>  
                            <!-- <div class="form-group col-md-2 laptop-item">
                                <label for="quantity">Price:</label>
                                <input type="number" name="laptops[0][price]" min="0" class="form-control quantity-input" value="{{ old('laptops.0.price', $laptop->price) }}" oninput="updateTotalPrice()">
                            </div>                          -->
                        </div>
                        <div class="form-row" style="padding: 0px 0px 0px 15px;">
                            <div class="form-group col-md-4">
                                <label for="state"><strong>State:</strong></label>
                                <select name="state" id="state" class="form-control" value="{{ old('state') }}" requided>
                                    <option value="1">Đang xử lí</option>
                                    <option value="0">Chưa xử lí</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="total"><strong>Total:</strong></label>
                                <label id="total" name="total" class="form-control" style="text-align: center; background-color: #e6ffff"></label>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('laptops.index') }}" class="btn btn-secondary">Back</a>
                                <button type="button" class="btn btn-success" onclick="addLaptop()">Add Another Laptop</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
function addLaptop() {
    var laptopContainer = document.getElementById('laptop-container');
    var laptopItems = document.querySelectorAll('.laptop-item');
    var lastItemIndex = laptopItems.length - 1;
    var lastItem = laptopItems[lastItemIndex];
    var newIndex = parseInt(lastItem.getAttribute('data-index')) + 1;

    var newLaptopItem = lastItem.cloneNode(true);
    newLaptopItem.setAttribute('data-index', newIndex);

    var selects = newLaptopItem.querySelectorAll('select');
    selects.forEach(function(select) {
        select.name = select.name.replace(/\[\d\]/, '[' + newIndex + ']');
    });

    var inputs = newLaptopItem.querySelectorAll('input');
    inputs.forEach(function(input) {
        input.name = input.name.replace(/\[\d\]/, '[' + newIndex + ']');
        input.value = '';
    });

    laptopContainer.appendChild(newLaptopItem);
    // var laptopContainer = document.getElementById('laptop-container');
    // var newLaptopItem = document.querySelector('.laptop-item').cloneNode(true);
    // laptopContainer.appendChild(newLaptopItem);
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
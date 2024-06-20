<x-app-layout>
    <div class="container">
        <h1>Create Order</h1>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_name">Seller Name:</label>
                <select name="user_name" id="user_name" class="form-control" value="">
                    <option value="">--- Chọn người bán ---</option>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}" {{ old('user_name') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="customer_name">Customer Name:</label>
                <select name="customer_name" id="customer_name" class="form-control" value="">
                    <option value="">--- Chọn khách hàng ---</option>
                    @foreach ($customers as $key => $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_name') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('customer_name'))
                    <div style="color: red;">{{ $errors->first('customer_name') }}</div>
                @endif
            </div>
            <div id="laptop-container">
                <div class="form-group laptop-item">
                    @php
                        $index = 0;
                    @endphp
                    <label for="laptop_name">Laptop:</label>
                    <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" >
                        <option value="">--- Chọn laptop ---</option>
                        @foreach ($laptops as $laptop)
                            <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old('laptops.'.$index.'.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                        @endforeach
                    </select>
                    @error('laptops.{{ $index }}.laptop_id')
                         <div style="color: red;">{{ $message }}</div>
                     @enderror
                     <div>
                    <label for="quantity">Quantity:</label>
                   <input type="number" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old('laptops.'.$index.'.quantity') }}" oninput="updateTotalPrice()">
                       @error('laptops.{{ $index }}.quantity')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select name="state" id="state" class="form-control" value="{{ old('state') }}">
                    <option value="1">Đang xử lí</option>
                    <option value="0">Chưa xử lí</option>
                </select>
                @if ($errors->has('state'))
                    @foreach ($errors->get('state') as $message)
                        <div style="color: red;">{{ $message }}</div>
                    @endforeach
                @endif
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <label id="total" name="total" class="form-control"></label>
            </div>
            <div style="padding-top: 5px" class="form-row">
                <button type="button" class="btn btn-secondary" onclick="addLaptop()">Add Another Laptop</button>
                 <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</x-app-layout>


<script>
function addLaptop() {
    const laptopContainer = document.getElementById('laptop-container');
    const laptopItems = document.querySelectorAll('.laptop-item');
    const newIndex = laptopItems.length;

    const newLaptopItem = document.createElement('div');
    newLaptopItem.classList.add('form-group', 'laptop-item');
    newLaptopItem.setAttribute('data-index', newIndex);

    newLaptopItem.innerHTML = `
        <div class="form-row">
            <div class="form-group col-md-6">
                <strong><label for="laptop_name" style="color: #04AA6D;">Laptop:</label></strong>
                <select name="laptops[${newIndex}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()">
                    <option></option>
                    @foreach ($laptops as $laptop)
                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <strong><label for="quantity" style="color: #04AA6D;">Quantity:</label></strong>
                <input type="number" name="laptops[${newIndex}][quantity]" class="form-control quantity-input" value="" oninput="updateTotalPrice()">
            </div>
            <div class="remove-button-container" style="margin-left: 1025px;">
                <button type="button" class="btn btn-outline-danger" onclick="removeLaptop(${newIndex})">Remove</button>
            </div>
        </div>
    `;

    laptopContainer.appendChild(newLaptopItem);
    updateRemoveButtons();
    updateTotalPrice();
}

function removeLaptop(index) {
    const laptopContainer = document.getElementById('laptop-container');
    const laptopItem = document.querySelector(`.laptop-item[data-index="${index}"]`);

    if (laptopItem) {
        laptopContainer.removeChild(laptopItem);
        updateRemoveButtons();
        updateTotalPrice();
    }
}

function updateRemoveButtons() {
    const removeButtons = document.querySelectorAll('.remove-button-container');
    if (removeButtons.length === 1) {
        removeButtons[0].style.display = 'none';
    } else {
        removeButtons.forEach(button => button.style.display = 'block');
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


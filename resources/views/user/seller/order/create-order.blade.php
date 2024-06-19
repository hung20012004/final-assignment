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
                    <label for="laptop_name">Laptop:</label>
                    <select name="laptops[0][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" >
                        <option value="">--- Chọn laptop ---</option>
                        @foreach ($laptops as $laptop)
                            <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old('laptops.0.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                        @endforeach
                    </select>
                    @error('laptops.0.laptop_id')
                         <div style="color: red;">{{ $message }}</div>
                     @enderror
                      <div style="padding-top: 5px">
                       <button type="button" class="btn btn-secondary" onclick="addLaptop()">Add Another Laptop</button>
                     </div>
                     <div>
                    <label for="quantity">Quantity:</label>
                   <input type="number" name="laptops[0][quantity]" class="form-control quantity-input" value="{{ old('laptops.0.quantity') }}" oninput="updateTotalPrice()">
                       @error('laptops.0.quantity')
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
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
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


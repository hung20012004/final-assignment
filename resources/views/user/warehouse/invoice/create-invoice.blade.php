<x-app-layout>
    <div class="container-fluid">
            <div class="row mx-lg-5 mx-md-0">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                    ['url' => route('invoices.create'), 'label' => 'Create Invoice'],
                ]" />
            </div>
            <div class="row justify-content-center mx-1 px-1">
                <div class="col-md-12 col-lg-11 col-sm-12">
                    <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="provider_id">Provider Name:</label>
                                <select name="provider_id" id="provider_id" class="form-control" value="" required>
                                    <option value="">--- Select provider ---</option>
                                    @foreach ($providers as $key => $provider)
                                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('provider_id'))
                                    <div style="color: red;">{{ $errors->first('provider_id') }}</div>
                                @endif
                            </div>
                            <div id="laptop-container">
                                <div class="form-group laptop-item">
                                    @php
                                        $index = 0;
                                    @endphp
                                    <label for="laptop_name">Laptop:</label>
                                    <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select">
                                        <option value="">--- Select laptop ---</option>
                                        @foreach ($laptops as $laptop)
                                            <option value="{{ $laptop->id }}" {{ old('laptops.'.$index.'.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('laptops.'.$index.'.laptop_id')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                    <div>
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" min="1" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old('laptops.'.$index.'.quantity') }}" oninput="updateTotalPrice(this)">
                                        @error('laptops.'.$index.'.quantity')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="price">Price:</label>
                                        <input type="number" min="0" name="laptops[{{ $index }}][price]" class="form-control price-input" value="{{ old('laptops.'.$index.'.price') }}" oninput="updateTotalPrice(this)">
                                        @error('laptops.'.$index.'.price')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="px-4 py-4 bg-white shadow-md mb-2 rounded">
                                        <table id="laptop-list" class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Laptop Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="text-align: right"><strong>Total Amount: </strong><span id="total-amount">0</span></div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left: 680px" class="form-row">
                                <button type="button" class="btn btn-secondary" onclick="addLaptop()" style="margin-right: 10px">Add Laptop</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>

                            <!-- Hidden inputs for storing laptops data -->
                            <input type="hidden" id="hidden-laptops" name="hidden_laptops">
                        </form>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>

<script>
    let laptopCount = 0;
    let totalAmount = 0;
    let laptopsData = []; // Array to store laptops data

    function updateTotalPrice(element) {
        const laptopItem = $(element).closest('.laptop-item');
        const price = parseFloat(laptopItem.find('.price-input').val()) || 0;
        const quantity = parseInt(laptopItem.find('.quantity-input').val()) || 0;
        const totalPrice = price * quantity;
        laptopItem.find('.total-price').text(totalPrice.toLocaleString() + ' VND');
    }

    function addLaptop() {
        const laptopItem = $('.laptop-item:last');
        const laptopSelect = laptopItem.find('.laptop-select');
        const laptopId = laptopSelect.val();
        const laptopName = laptopSelect.find('option:selected').text();
        const quantityToAdd = parseInt(laptopItem.find('.quantity-input').val()) || 0;
        const laptopPrice = parseFloat(laptopItem.find('.price-input').val()) || 0;

        if (!laptopId || quantityToAdd <= 0 || laptopPrice <= 0) {
            alert('Please select a laptop, enter a valid quantity, and enter a valid price.');
            return;
        }

        let laptopExists = false;
        $('#laptop-list tbody tr').each(function() {
            const row = $(this);
            const existingLaptopId = row.data('id');
            if (existingLaptopId == laptopId) {
                let existingQuantity = parseInt(row.find('td:eq(2)').text().trim());
                let newQuantity = existingQuantity + quantityToAdd;
                let newTotal = newQuantity * laptopPrice;

                row.find('td:eq(2)').text(newQuantity);
                row.find('td:eq(4)').text(newTotal.toLocaleString('vi-VN') + ' VND');
                laptopExists = true;

                laptopsData.forEach(laptop => {
                    if (laptop.id == laptopId) {
                        laptop.quantity = newQuantity;
                        laptop.total = newTotal;
                    }
                });
            }
        });

        if (!laptopExists) {
            laptopCount++;
            const laptopTotal = quantityToAdd * laptopPrice;
            const laptopData = {
                id: laptopId,
                name: laptopName,
                quantity: quantityToAdd,
                price: laptopPrice,
                total: laptopTotal
            };

            laptopsData.push(laptopData);

            const laptopRow = `
                <tr data-id="${laptopId}">
                    <td>${laptopId}</td>
                    <td>${laptopName}</td>
                    <td>${quantityToAdd}</td>
                    <td>${laptopPrice.toLocaleString()}</td>
                    <td>${laptopTotal.toLocaleString('vi-VN')}</td>
                    <td><button class="btn btn-danger btn-sm remove-laptop">Remove</button></td>
                </tr>
            `;
            $('#laptop-list tbody').append(laptopRow);
        }

        totalAmount += quantityToAdd * laptopPrice;
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
        laptopSelect.val('');
        laptopItem.find('.quantity-input').val('');
        laptopItem.find('.price-input').val('');
        updateHiddenInput();
    }

    $(document).on('click', '.remove-laptop', function() {
        const row = $(this).closest('tr');

        // Get laptop price
        const laptopPriceStr = row.find('td:eq(3)').text().trim();
        const laptopPriceCleaned = laptopPriceStr.replace(/\./g, ""); // Remove dots
        const laptopPrice = parseFloat(laptopPriceCleaned);

        // Get quantity
        const quantityStr = row.find('td:eq(2)').text().trim();
        const quantity = parseInt(quantityStr.replace(/[^0-9]/g, "").trim());

        // Calculate total for the laptop
        const laptopTotal = laptopPrice * quantity;

        // Update total amount
        totalAmount -= laptopTotal;
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        // Remove row from the table
        row.remove();
    });

    function updateHiddenInput() {
        // Update hidden input value with JSON stringified laptopsData
        $('#hidden-laptops').val(JSON.stringify(laptopsData));
    }

    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }
</script>

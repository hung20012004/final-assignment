<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                    ['url' => route('invoices.edit', $invoice->id), 'label' => 'Edit Invoice'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Invoice</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <strong><label for="id">ID:</label></strong>
                                <input type="text" name="id" id="id" class="form-control" style="text-align: center" value="{{ old('id', $invoice->id) }}" readonly>
                            </div>
                            <div class="form-group">
                                <strong><label for="user_name">Seller Name:</label></strong>
                                <select name="user_id" id="user_id" class="form-control" style="text-align: center">
                                    <option value="{{ $invoice->user_id }}">{{ $invoice->user->name }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_name'))
                                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <strong><label for="customer_name">Customer Name:</label></strong>
                                <select name="customer_id" id="customer_id" class="form-control" style="text-align: center">
                                    <option value="{{ $invoice->customer_id }}">{{ $invoice->customer->name }}</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('customer_name'))
                                    @foreach ($errors->get('customer_name') as $message)
                                        <div style="color: red;">{{ $message }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div id="laptop-container">
                                @php $total = 0; @endphp
                                @foreach ($invoice->invoice_detail as $index => $invoiceDetail)
                                    <div class="form-row laptop-item" data-index="{{ $index }}">
                                        <div class="form-group col-md-4">
                                            <strong><label for="laptop_name">Laptop:</label></strong>
                                            <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" style="text-align: center">
                                                <option value="{{ $invoiceDetail->laptop_id }}" data-price="{{ $invoiceDetail->laptop->price }}">{{ $invoiceDetail->laptop->name }}</option>
                                                @foreach ($laptops as $laptop)
                                                    <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old("laptops.{$index}.laptop_id") == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("laptops.{$index}.laptop_id")
                                                <div style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <strong><label for="unit_price">Unit Price:</label></strong>
                                            <input type="number" name="laptops[{{ $index }}][unit_price]" class="form-control unit-price-input" value="{{ old("laptops.{$index}.unit_price", $invoiceDetail->laptop->price) }}" oninput="updateTotalPrice()" style="text-align: center">
                                            @error("laptops.{$index}.unit_price")
                                                <div style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <strong><label for="quantity">Quantity:</label></strong>
                                            <input type="number" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old("laptops.{$index}.quantity", $invoiceDetail->quantity) }}" oninput="updateTotalPrice()" style="text-align: center">
                                            @error("laptops.{$index}.quantity")
                                                <div style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <strong><label>Total Price:</label></strong>
                                            <div class="total-price" style="text-align: center">{{ number_format($invoiceDetail->quantity * $invoiceDetail->laptop->price, 0, ',', '.') }} VND</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <strong><label for="state">State:</label></strong>
                                <select name="state" id="state" class="form-control" style="text-align: center">
                                    <option value="1" {{ $invoice->state == 1 ? 'selected' : '' }}>Processing</option>
                                    <option value="0" {{ $invoice->state == 0 ? 'selected' : '' }}>Not Processed</option>
                                </select>
                                @if ($errors->has('state'))
                                    @foreach ($errors->get('state') as $message)
                                        <div style="color: red;">{{ $message }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="px-4 py-2 bg-white shadow-md mt-3 rounded">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <strong><label for="new_laptop_name">New Laptop Name:</label></strong>
                                                <select id="new_laptop_name" class="form-control" style="text-align: center">
                                                    <option value=""></option>
                                                    @foreach ($laptops as $laptop)
                                                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <strong><label for="new_unit_price">Unit Price:</label></strong>
                                                <input type="number" id="new_unit_price" class="form-control" style="text-align: center">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <strong><label for="new_laptop_quantity">Quantity:</label></strong>
                                                <input type="number" id="new_laptop_quantity" class="form-control" style="text-align: center">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="button" class="btn btn-success" style="margin-top: 30px;" onclick="addNewLaptop()">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="px-4 py-2 bg-white shadow-md mb-2 rounded">
                                        <table id="laptop-list" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Laptop Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="text-align: right"><strong>Total Amount: </strong><span id="total-amount">0 VND</span></div>
                                        <!-- Hidden inputs for storing laptops data -->
                                        <input type="hidden" id="hidden-laptops" name="hidden_laptops">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-left: 980px; margin-bottom: 10px">
                                <div style="padding-top: 5px"><button type="submit" class="btn btn-primary">Save</button></div>
                            </div>
                        </form>
                    </div>
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
        const unitPrice = parseFloat(laptopItem.find('.unit-price-input').val());
        const quantity = parseInt(laptopItem.find('.quantity-input').val());
        const totalPrice = unitPrice * quantity;
        laptopItem.find('.total-price').text(totalPrice.toLocaleString('vi-VN') + ' VND');

        // Update total amount
        totalAmount = 0;
        $('.laptop-item').each(function() {
            const unitPrice = parseFloat($(this).find('.unit-price-input').val());
            const quantity = parseInt($(this).find('.quantity-input').val());
            totalAmount += unitPrice * quantity;
        });
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        // Update hidden input
        updateHiddenInput();
    }

    function addNewLaptop() {
        const laptopSelect = $('#new_laptop_name');
        const laptopId = laptopSelect.val();
        const laptopName = laptopSelect.find('option:selected').text();
        const unitPrice = parseFloat($('#new_unit_price').val());
        const quantity = parseInt($('#new_laptop_quantity').val());

        if (!laptopId || !unitPrice || !quantity) {
            alert('Please select a laptop and enter unit price and quantity.');
            return;
        }

        const laptopRow = `
            <tr data-id="${laptopId}">
                <td>${laptopId}</td>
                <td>${laptopName}</td>
                <td><input type="number" class="form-control unit-price-input" value="${unitPrice}" oninput="updateTotalPrice(this)" style="text-align: center"></td>
                <td><input type="number" class="form-control quantity-input" value="${quantity}" oninput="updateTotalPrice(this)" style="text-align: center"></td>
                <td class="total-price" style="text-align: center">${(unitPrice * quantity).toLocaleString('vi-VN')} VND</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-laptop" onclick="removeLaptop(this)">Remove</button></td>
            </tr>
        `;

        $('#laptop-list tbody').append(laptopRow);

        const laptopData = {
            id: laptopId,
            name: laptopName,
            unit_price: unitPrice,
            quantity: quantity,
            total: unitPrice * quantity
        };
        laptopsData.push(laptopData);

        // Update total amount
        totalAmount += unitPrice * quantity;
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        // Update hidden input
        updateHiddenInput();

        // Reset the select and quantity input
        laptopSelect.val('');
        $('#new_unit_price').val('');
        $('#new_laptop_quantity').val('');
    }

    function removeLaptop(button) {
        const row = $(button).closest('tr');
        const laptopId = row.data('id');
        const unitPrice = parseFloat(row.find('.unit-price-input').val());
        const quantity = parseInt(row.find('.quantity-input').val());

        totalAmount -= unitPrice * quantity;
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        row.remove();

        laptopsData = laptopsData.filter(laptop => laptop.id != laptopId);
        updateHiddenInput();
    }

    function updateHiddenInput() {
        $('#hidden-laptops').val(JSON.stringify(laptopsData));
    }
</script>

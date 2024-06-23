<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                    ['url' => route('invoices.edit', $invoice->id), 'label' => 'Edit Invoice'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-4" style="padding: 0;">
                                <strong><label for="user_name">Warehouse Staff:</label></strong>
                                <select name="user_id" id="user_id" class="form-control" style="text-align: center" required>
                                    <option value="{{ $invoice->user_id }}">{{ $invoice->user->name }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4" style="padding: 0;">
                                <strong><label for="provider_name">Provider:</label></strong>
                                <select name="provider_id" id="provider_id" class="form-control" style="text-align: center" required>
                                    <option value="{{ $invoice->provider_id }}">{{ $invoice->provider->name }}</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="invoice-details-container">
                                @php $total = 0; @endphp
                                @foreach ($invoice->invoice_detail as $index => $invoiceDetail)
                                    <div class="form-row invoice-detail-item" data-index="{{ $index }}">
                                        <div class="form-group col-md-4">
                                            <strong><label for="laptop_name">Laptop:</label></strong>
                                            <select name="invoice_details[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()">
                                                <option value="{{ $invoiceDetail->laptop_id }}" data-price="{{ $invoiceDetail->laptop->price }}">{{ $invoiceDetail->laptop->name }}</option>
                                                @foreach ($laptops as $laptop)
                                                    <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <strong><label for="quantity">Quantity:</label></strong>
                                            <input type="number" name="invoice_details[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old("invoice_details.{$index}.quantity", $invoiceDetail->quantity) }}" oninput="updateTotalPrice()">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <strong><label for="price">Price:</label></strong>
                                            <input type="number" name="invoice_details[{{ $index }}][price]" class="form-control price-input" value="{{ old("invoice_details.{$index}.price", $invoiceDetail->price) }}" oninput="updateTotalPrice()">
                                        </div>
                                        <div class="remove-button-container form-group col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger" onclick="removeInvoiceDetail(this)">Remove</button>
                                        </div>
                                    </div>
                                    @php $total += $invoiceDetail->quantity * $invoiceDetail->price; @endphp
                                @endforeach
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <strong><label for="state">State:</label></strong>
                                    <select name="state" id="state" class="form-control" style="text-align: center">
                                        <option value="1" {{ $invoice->state == 1 ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="0" {{ $invoice->state == 0 ? 'selected' : '' }}>Hủy</option>
                                    </select>
                                    @error('state')
                                        <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <strong><label for="total">Total:</label></strong>
                                    <label id="total" class="form-control" style="text-align: center; background-color: #e6ffff">{{ number_format($total, 0, ',', '.') }} đ</label>
                                </div>
                                <input type="hidden" id="hiddenTotal" name="hiddenTotal" value="{{ $total }}">
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
                                <button type="button" class="btn btn-success" onclick="addInvoiceDetail()">Add Another Laptop</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function addInvoiceDetail() {
        const invoiceDetailsContainer = document.getElementById('invoice-details-container');
        const invoiceDetails = invoiceDetailsContainer.querySelectorAll('.invoice-detail-item');
        const newIndex = invoiceDetails.length;

        const newInvoiceDetailItem = document.createElement('div');
        newInvoiceDetailItem.classList.add('form-row', 'invoice-detail-item');
        newInvoiceDetailItem.setAttribute('data-index', newIndex);

        newInvoiceDetailItem.innerHTML = `
            <div class="form-group col-md-4">
                <strong><label for="laptop_name">Laptop:</label></strong>
                <select name="invoice_details[${newIndex}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()">
                    @foreach ($laptops as $laptop)
                        <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <strong><label for="quantity">Quantity:</label></strong>
                <input type="number" name="invoice_details[${newIndex}][quantity]" class="form-control quantity-input" value="" oninput="updateTotalPrice()">
            </div>
            <div class="form-group col-md-2">
                <strong><label for="price">Price:</label></strong>
                <input type="number" name="invoice_details[${newIndex}][price]" class="form-control price-input" value="" oninput="updateTotalPrice()">
            </div>
            <div class="remove-button-container form-group col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger" onclick="removeInvoiceDetail(this)">Remove</button>
            </div>
        `;

        invoiceDetailsContainer.appendChild(newInvoiceDetailItem);
        updateTotalPrice();
    }

    function removeInvoiceDetail(button) {
        const invoiceDetailItem = button.closest('.invoice-detail-item');

        if (invoiceDetailItem) {
            invoiceDetailItem.remove();
            updateTotalPrice();
        }
    }

    function updateTotalPrice() {
        const invoiceDetailItems = document.querySelectorAll('.invoice-detail-item');
        let total = 0;

        invoiceDetailItems.forEach(item => {
            const laptopSelect = item.querySelector('.laptop-select');
            const priceInput = item.querySelector('.price-input');
            const quantityInput = item.querySelector('.quantity-input');

            if (laptopSelect && priceInput && quantityInput) {
                const selectedLaptop = laptopSelect.options[laptopSelect.selectedIndex];
                const price = parseFloat(selectedLaptop.getAttribute('data-price')) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const totalPrice = price * quantity;
                total += totalPrice;
                priceInput.value = price; // Update price input with selected laptop's price
            }
        });

        const totalElement = document.getElementById('total');
        totalElement.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
        document.getElementById('hiddenTotal').value = total;
    }
</script>

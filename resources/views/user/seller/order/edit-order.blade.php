<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="row mx-lg-5 mx-md-0">
                <x-breadcrumb :links="[
                    ['url' => route('orders.index'), 'label' => 'Orders'],
                    ['url' => route('orders.edit', $order->id), 'label' => 'Edit Order'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                 @if($errors->has('quantity'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->get('quantity') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Order</h5>
                    </div>
                    <div class="card-body">

        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-md-6">
                <strong><label for="name">ID:</label></strong>
                <input type="text" name="id" id="id" class="form-control" style="text-align: center" value="{{ old('id', $order->id) }}" readonly>
            </div>
            <div class="form-group col-md-6">
                <strong><label for="user_name">Seller:</label></strong>
                <input type="text" class="form-control" style="text-align: center" placeholder="{{ Auth::user()->name }}" disabled>
                <input type="text" name="user_id" id="user_id" class="form-control" value="{{ Auth::user()->id }}" hidden>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                @endif
            </div>
            </div>
            
            <div class="form-group">
                <strong><label for="customer_name">Customer:</label></strong>
                <select name="customer_id" id="customer_id" class="form-control" style="text-align: center">
                    <option value="{{ $order->customer_id }}">{{ $order->customer->name }}</option>
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
                @foreach ($order->order_detail as $index => $orderDetail)
                    <div class="form-row laptop-item" data-index="{{ $index }}">
                        <div class="form-group col-md-6">
                            <strong><label for="laptop_name">Laptop:</label></strong>
                            <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()" style="text-align: center">
                                <option value="{{ $orderDetail->laptop_id }}" data-price="{{ $orderDetail->laptop->price }}">{{ $orderDetail->laptop->name }}</option>
                                @foreach ($laptops as $laptop)
                                    <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old("laptops.{$index}.laptop_id") == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                @endforeach
                            </select>
                            @error("laptops.{$index}.laptop_id")
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <strong><label for="quantity">Quantity:</label></strong>
                            <input type="number" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old("laptops.{$index}.quantity", $orderDetail->quantity) }}" oninput="updateTotalPrice()" style="text-align: center">
                            @error("laptops.{$index}.quantity")
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
                <div class="form-group">
                    <strong><label for="state">State:</label></strong>
                    <select name="state" id="state" class="form-control" style="text-align: center">
                        <option value="1" {{ $order->state == 0 ? 'selected' : '' }}>Cancel</option>
                        <option value="0" {{ $order->state == 1 ? 'selected' : '' }}>Undischarged</option>
                        <option value="0" {{ $order->state == 2 ? 'selected' : '' }}>Discharged</option>
                    </select>
                    @if ($errors->has('state'))
                        @foreach ($errors->get('state') as $message)
                            <div style="color: red;">{{ $message }}</div>
                        @endforeach
                    @endif
                 </div>
                 <div class="row justify-content-center ">
                  <div class="col-md-12 ">
                     <div class="px-4 py-3 bg-white shadow-md mt-3 rounded">
                <div class="form-row">
                <div class="form-group col-md-6">
                    <strong><label for="new_laptop_name">New Laptop:</label></strong>
                    <select id="new_laptop_name" class="form-control" style="text-align: center; background: ghostwhite">
                         <option value=""></option>
                        @foreach ($laptops as $laptop)
                            <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}">{{ $laptop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <strong><label for="new_laptop_quantity">Quantity:</label></strong>
                    <input type="number" id="new_laptop_quantity" class="form-control" style="text-align: center ; background: ghostwhite">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-success" style="margin-top: 30px;" onclick="addNewLaptop()">Add</button>
                </div>
            </div>
                 </div>
               </div>
             </div>
            <div class="row justify-content-center ">
                  <div class="col-md-12 ">
                     <div class="px-4 py-2 bg-white shadow-md mb-2 rounded">
                            <table id="laptop-list" class="table table-striped">
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
            
            <!-- Hidden inputs for storing laptops data -->
            <input type="hidden" id="hidden-laptops" name="hidden_laptops">
             </div>
               </div>
             </div>
            <!-- Inputs for adding new laptops -->
            
            <div class="form-group col-md-12" style=" margin-bottom: 10px; text-align: right">
                <div style="padding-top: 5px"><button type="submit" class="btn btn-primary">Save</button></div>
            </div>
        </form>
        </div>
            </div>
        </div>
    </div>

     <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Salary Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('salary.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="monthexport">Month</label>
                            <select name="monthexport" id="monthexport" class="form-control" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Năm</label>
                            <select name="yearexport" id="yearexport" class="form-control" required>
                                @for ($y = date('Y') - 10; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    let laptopCount = 0;
    let totalAmount = 0;
    let laptopsData = []; // Array to store laptops data

    function updateTotalPrice(element) {
        const laptopSelect = $(element).closest('.laptop-item').find('.laptop-select');
        const selectedOption = laptopSelect.find('option:selected');
        const price = parseFloat(selectedOption.data('price')) || 0;
        const quantity = parseInt($(element).closest('.laptop-item').find('.quantity-input').val()) || 0;
        const totalPrice = price * quantity;
        $(element).closest('.laptop-item').find('.total-price').text(totalPrice.toLocaleString() + ' VND');
    }

 function addNewLaptop() {
    const laptopSelect = $('#new_laptop_name');
    const laptopId = laptopSelect.val();
    const laptopName = laptopSelect.find('option:selected').text();
    const quantityToAdd = parseInt($('#new_laptop_quantity').val()) || 0;
    const laptopPrice = parseFloat(laptopSelect.find('option:selected').data('price')) || 0;

    // Kiểm tra xem laptop đã có trong danh sách chưa
    let laptopExists = false;
    $('#laptop-list tbody tr').each(function() {
        const row = $(this);
        const existingLaptopId = row.data('id');
        if (existingLaptopId == laptopId) {
            // Nếu laptop đã tồn tại, cộng dồn số lượng
            let existingQuantity = parseInt(row.find('td:eq(2)').text().trim());
            let newQuantity = existingQuantity + quantityToAdd;
            let newTotal = newQuantity * laptopPrice;

            row.find('td:eq(2)').text(newQuantity);
            row.find('td:eq(4)').text(newTotal.toLocaleString('vi-VN') + ' VND');
            laptopExists = true;

            // Cập nhật dữ liệu trong laptopsData
            laptopsData.forEach(laptop => {
                if (laptop.id == laptopId) {
                    laptop.quantity = newQuantity;
                    laptop.total = newTotal;
                }
            });
        }
    });

    if (!laptopExists) {
        // Nếu chưa có thì thêm mới vào laptopsData và UI
        const laptopData = {
            id: laptopId,
            name: laptopName,
            quantity: quantityToAdd,
            price: laptopPrice,
            total: quantityToAdd * laptopPrice
        };
        laptopsData.push(laptopData);

        const laptopRow = `
            <tr data-id="${laptopId}">
                <td>${laptopId}</td>
                <td>${laptopName}</td>
                <td>${quantityToAdd}</td>
                <td>${laptopPrice.toLocaleString()} </td>
                <td>${(quantityToAdd * laptopPrice).toLocaleString()} </td>
                <td><button class="btn btn-danger btn-sm" onclick="removeLaptop(this)">Xóa</button></td>
            </tr>
        `;
        $('#laptop-list tbody').append(laptopRow);
    }

    // Cập nhật tổng tiền
    totalAmount = laptopsData.reduce((sum, laptop) => sum + laptop.total, 0);
    $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

    // Cập nhật hidden input
    updateHiddenInput();

    // Đặt lại giá trị select và input quantity
    laptopSelect.val('');
    $('#new_laptop_quantity').val('');
}

function removeLaptop(button) {
    const row = $(button).closest('tr');
    const laptopId = row.data('id');
    const quantity = parseInt(row.find('td:eq(2)').text().trim());
    const price = parseFloat(row.find('td:eq(3)').text().replace(/\D/g, '')) / 100; // Assuming price format is VND

    // Tính toán lại tổng tiền
    totalAmount -= quantity * price;
    $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

    // Xóa hàng từ bảng
    row.remove();

    // Cập nhật dữ liệu trong laptopsData
    laptopsData = laptopsData.filter(laptop => laptop.id != laptopId);
    updateHiddenInput();
}

    $(document).on('click', '.remove-laptop', function() {
        const row = $(this).closest('tr');
        
        // Lấy giá tiền của laptop
        const laptopPriceStr = row.find('td:eq(3)').text().trim(); // Giá tiền của 1 laptop
        const laptopPriceCleaned = laptopPriceStr.replace(/\./g, ""); // Xóa dấu chấm
        const laptopPrice = parseFloat(laptopPriceCleaned);

        // Lấy số lượng
        const quantityStr = row.find('td:eq(2)').text().trim(); // Số lượng
        const quantity = parseInt(quantityStr.replace(/[^0-9]/g, "").trim());
        
        // Tính giá tiền của 1 laptop nhân với số lượng
        const laptopTotal = laptopPrice * quantity;

        // In giá trị laptopTotal ra console (nếu cần thiết)
        console.log('Laptop Total (Price * Quantity): ', laptopTotal);

        // Cập nhật tổng số tiền
        totalAmount -= laptopTotal;
        $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
        
        // Xóa hàng trong bảng
        row.remove();

        // Xóa dữ liệu laptop từ laptopsData
        const laptopId = row.data('id');
        laptopsData = laptopsData.filter(laptop => laptop.id !== laptopId);
        updateHiddenInput(); // Update hidden input value with laptopsData
    });

  function updateHiddenInput() {
    $('#hidden-laptops').val(JSON.stringify(laptopsData));
}

    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }
</script>
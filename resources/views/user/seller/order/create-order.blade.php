<x-app-layout>
       <div class="container">
         <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('orders.index'), 'label' => 'Orders'],
                ['url' => route('orders.create'), 'label' => 'Create order'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    @if($errors->has('quantity'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->get('quantity') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
        <form  action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_name">Seller:</label>
                <input type="text" class="form-control" placeholder="{{ Auth::user()->name }}" disabled>
                <input type="text" name="user_id" id="user_id" class="form-control" value="{{ Auth::user()->id }}" hidden>
                @if ($errors->has('user_id'))
                    <div style="color: red;">{{ $errors->first('user_id') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="customer_name">Customer:</label>
                <select name="customer_id" id="customer_id" class="form-control" value="">
                    <option value=""></option>
                    @foreach ($customers as $key => $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('customer_id'))
                    <div style="color: red;">{{ $errors->first('customer_id') }}</div>
                @endif
            </div>
            <div id="laptop-container">
                <div class="form-group laptop-item">
                    @php
                        $index = 0;
                    @endphp
                    <label for="laptop_name">Laptop:</label>
                    <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice(this)" >
                        <option value=""></option>
                        @foreach ($laptops as $laptop)
                            <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old('laptops.'.$index.'.laptop_id') == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                        @endforeach
                    </select>
                    @error('laptops.'.$index.'.laptop_id')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                    <div>
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old('laptops.'.$index.'.quantity') }}" oninput="updateTotalPrice(this)">
                        @error('laptops.'.$index.'.quantity')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <select name="state" id="state" class="form-control" value="{{ old('state') }}">
                    <option value="0">Cancel</option>
                    <option value="1" selected>Undischarged</option>
                    <option value="2">Discharged</option>
                </select>
                @if ($errors->has('state'))
                    @foreach ($errors->get('state') as $message)
                        <div style="color: red;">{{ $message }}</div>
                    @endforeach
                @endif
            </div>
             <div class="row justify-content-center ">
               <div class="col-md-12 ">
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
                <button type="button" class="btn btn-success" onclick="addLaptop()" style="margin-right: 10px">Add Laptop</button>
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
    let laptopCount = 0;  // Đếm laptop thêm vào
    let totalAmount = 0;  // Tính tổng tiền
    let laptopsData = []; // Lưu trữ các Laptop

    // function updateTotalPrice(element) {
    //     const laptopSelect = $(element).closest('.laptop-item').find('.laptop-select');
    //     const selectedOption = laptopSelect.find('option:selected');
    //     const price = parseFloat(selectedOption.data('price')) || 0;
    //     const quantity = parseInt($(element).closest('.laptop-item').find('.quantity-input').val()) || 0;
    //     const totalPrice = price * quantity;
    //     $(element).closest('.laptop-item').find('.total-price').text(totalPrice.toLocaleString() + ' VND');
    // }

    function addLaptop() {
    const laptopSelect = $('.laptop-item:last .laptop-select');
    const laptopId = laptopSelect.val();
    const laptopName = laptopSelect.find('option:selected').text();
    const quantityToAdd = parseInt($('.laptop-item:last .quantity-input').val()) || 0;
    const laptopPrice = parseFloat(laptopSelect.find('option:selected').data('price')) || 0;

    if (!laptopId || quantityToAdd <= 0) {
        alert('Please select a laptop and enter a valid quantity.');
        return;
    } // Nếu không chọn laptop hoặc số lượng sẽ bắt chọn

    let laptopExists = false;  // để biến laptop exist = false
    $('#laptop-list tbody tr').each(function() {// tại table có id là laptop-list và ở phần tbody, các dòng tr
        const row = $(this);    //gán biến row= các dòng hiện tại 
        const existingLaptopId = row.data('id');// gán biến existingLaptopId =  dòng hiện tại lấy data-id của dòng
        if (existingLaptopId == laptopId) {    //nếu  biến exist = cái laptop mà đang chọn ở thẻ selecct
            let existingQuantity = parseInt(row.find('td:eq(2)').text().trim()); // Lấy số lượng ở dòng số 3 hiện tại ở bảng và ép kiểu
            let newQuantity = existingQuantity + quantityToAdd;   // Lấy só lượng ở bảng + số lượng ở thẻ input
            let newTotal = newQuantity * laptopPrice;   // Giá = giá 1 laptop *số lượng mới

            row.find('td:eq(2)').text(newQuantity);   // Gán lại nội dung lên dòng số 3 là số lượng mới
            row.find('td:eq(4)').text(newTotal.toLocaleString('vi-VN') + ' VND');   // Gán lại nội dung lên dòng tổng tiền
            laptopExists = true;

            laptopsData.forEach(laptop => {   //chạt vòng lặp ccác laptop trong mảng laptop-data
                if (laptop.id == laptopId) {    // Nếu laptop trong data có id = laptopID(laptop ở thẻ input);
                    laptop.quantity = newQuantity; // số lượng mới 
                    laptop.total = newTotal;  // Tổng tiền mới
                }
            });
        }
    });

    if (!laptopExists) {    // nếu ch có laptop đó ở bảng
        laptopCount++;     // Tăng số lượng đếm lên
        const laptopTotal = quantityToAdd * laptopPrice;   // Laptop Total = số lượng ở input * giá
        const laptopData = {  // Tạo 1 laptop có các thuộc tính
            id: laptopId,   
            name: laptopName,
            quantity: quantityToAdd,
            price: laptopPrice,
            total: laptopTotal
        };

        laptopsData.push(laptopData);  // Đẩy vào mảng laptopsData 1 laptopData

         // Khởi tạo biền row lưu laptop
        const laptopRow = `    
            <tr data-id="${laptopId}">
                <td>${laptopId}</td>
                <td>${laptopName}</td>
                <td>${quantityToAdd}</td>
                <td>${laptopPrice.toLocaleString()}</td> 
                <td>${laptopTotal.toLocaleString('vi-VN')}</td>
                <td><button class="btn btn-danger btn-sm remove-laptop">Xóa</button></td>
            </tr>
        `;
        $('#laptop-list tbody').append(laptopRow); // add vào bảng ở phần tbody dòng laptopRow
    }

    totalAmount += quantityToAdd * laptopPrice; //Tổng tiền = số  lượng nhân đơn giấ
    $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));  // Chèn số liệu vào ô Tổng tiền
    laptopSelect.val('');  // Để lại giá trị cho biến chọn laptop và số lượng = ''
    $('.quantity-input').val('');
    updateHiddenInput();
    }

   $(document).on('click', '.remove-laptop', function() { 
    const row = $(this).closest('tr');  // Lấy hàng hiện tại gán vào biển row
    
    // Lấy giá tiền của laptop
    const laptopPriceStr = row.find('td:eq(3)').text().trim(); // Giá tiền của 1 laptop
    const laptopPriceCleaned = laptopPriceStr.replace(/\./g, ""); // Xóa dấu chấm
    const laptopPrice = parseFloat(laptopPriceCleaned);   // ép kiểu để ra giá

    // Lấy số lượng
    const quantityStr = row.find('td:eq(2)').text().trim(); // Số lượng
    const quantity = parseInt(quantityStr.replace(/[^0-9]/g, "").trim());

    // Tính giá tiền của 1 laptop nhân với số lượng
    const laptopTotal = laptopPrice * quantity;

    // In giá trị laptopTotal ra console (nếu cần thiết)
    console.log('Laptop Total (Price * Quantity): ', laptopTotal);

    // Cập nhật tổng số tiền
    totalAmount -= laptopTotal;
    $('#total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })); // in vào thẻ có id total-amount giá tiền
    
    // Xóa hàng trong bảng
    row.remove();
});

    function updateHiddenInput() {
        // Update hidden input value with JSON stringified laptopsData
        $('#hidden-laptops').val(JSON.stringify(laptopsData)); // dữ liệu ở laptopsData chuyển thành chuỗi json và gán vào value của input ẩn
    }

    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }
</script>

<x-app-layout>
    <div class="container">
        <h1>Edit Order</h1>
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <strong> <label for="name">ID:</label></strong>
                <input type="text" name="id" id="id" class="form-control" value="{{ old('id', $order->id) }}" readonly>
            </div>
            <div class="form-group">
                <strong><label for="user_name">Seller Name:</label></strong>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="{{ $order->user_id }}">{{ $order->user->name }}</option>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <strong><label for="customer_name">Customer Name:</label></strong>
                <select name="customer_id" id="customer_id" class="form-control">
                    <option value="{{ $order->customer_id }}">{{ $order->customer->name }}</option>
                    @foreach ($customers as $key => $customer)
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
                <div class="form-group laptop-item" data-index="0">
                    @php
                        $total = 0; // Khởi tạo biến tổng tiền
                    @endphp
                    @foreach ($order->order_detail as $index => $orderDetail)
                        <div class="form-group laptop-item" data-index="{{ $index }}">
                            <strong><label for="laptop_name">Laptop:</label></strong>
                            <select name="laptops[{{ $index }}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()">
                                <option value="{{ $orderDetail->laptop_id }}">{{ $orderDetail->laptop->name }}</option>
                                @foreach ($laptops as $laptop)
                                    <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old("laptops.{$index}.laptop_id") == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
                                @endforeach
                            </select>
                            @error("laptops.{$index}.laptop_id")
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                            <div style="padding-top: 5px">
                                <button type="button" class="btn btn-outline-success" onclick="addLaptop()">Add Another Laptop</button>
                            </div>
                            <div>
                                <strong><label for="quantity">Quantity:</label></strong>
                                <input type="number" name="laptops[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ old("laptops.{$index}.quantity", $orderDetail->quantity) }}" oninput="updateTotalPrice()">
                                @error("laptops.{$index}.quantity")
                                    <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @php
                            $total += $orderDetail->quantity * $orderDetail->laptop->price; // Cộng vào tổng tiền
                        @endphp
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <strong><label for="state">State:</label></strong>
                <select name="state" id="state" class="form-control">
                    <option value="1" {{ $order->state == 1 ? 'selected' : '' }}>Đang xử lí</option>
                    <option value="0" {{ $order->state == 0 ? 'selected' : '' }}>Chưa xử lí</option>
                </select>
                @if ($errors->has('state'))
                    @foreach ($errors->get('state') as $message)
                        <div style="color: red;">{{ $message }}</div>
                    @endforeach
                @endif
            </div>
            <div class="form-group">
               <strong><label for="total">Total:</label></strong> 
                <label id="total" name="total" class="form-control">{{ number_format($total, 0, ',', '.') }} đ</label>
            </div>
            <input type="hidden" id="initialTotal" value="{{ $total }}">
            <input type="hidden" id="hiddenTotal" name="hiddenTotal" value="{{ $total }}">
            <div style="text-align: center"><button type="submit" class="btn btn-primary">Save</button></div>
        </form>
    </div>
</x-app-layout>

<script>
let initialTotal = parseFloat(document.getElementById('initialTotal').value) || 0; // lấy từ input có tên tương ứng và nếu gtri ko hợp lệ thì nhận 0

function addLaptop() {
   const laptopContainer = document.getElementById('laptop-container');
    const laptopItems = document.querySelectorAll('.laptop-item');
    const newIndex = laptopItems.length; // Số lượng phần tử hiện tại, không cần trừ 1 vì mình sẽ không sao chép từ phần tử cuối cùng
   
     // Tạo một phần tử laptop mới
    const newLaptopItem = document.createElement('div');
    newLaptopItem.classList.add('form-group', 'laptop-item');
    newLaptopItem.setAttribute('data-index', newIndex);

     // Nội dung của phần tử laptop mới
    newLaptopItem.innerHTML = `
        <strong><label for="laptop_name" style="color: #04AA6D;">Laptop:</label></strong>
        <select name="laptops[${newIndex}][laptop_id]" class="form-control laptop-select" onchange="updateTotalPrice()">
            @foreach ($laptops as $laptop)
                    <option value="{{ $laptop->id }}" data-price="{{ $laptop->price }}" {{ old("laptops.{$index}.laptop_id") == $laptop->id ? 'selected' : '' }}>{{ $laptop->name }}</option>
            @endforeach
        </select>
        <div>
            <strong><label for="quantity" style="color: #04AA6D;">Quantity:</label></strong>
            <input type="number" name="laptops[${newIndex}][quantity]" class="form-control quantity-input" value="" oninput="updateTotalPrice()">
        </div>
    `;

    laptopContainer.appendChild(newLaptopItem);
    updateTotalPrice(); // Cập nhật tổng tiền sau khi thêm laptop mới
}

function updateTotalPrice() {
    const laptopSelects = document.querySelectorAll('.laptop-select');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalLabel = document.getElementById('total');
    let total = initialTotal;

    laptopSelects.forEach((laptopSelect, index) => {
        const selectedLaptop = laptopSelect.options[laptopSelect.selectedIndex];
        const price = parseFloat(selectedLaptop.getAttribute('data-price')) || 0;
        const quantity = parseFloat(quantityInputs[index].value) || 0;
        total += price * quantity;
    });

    totalLabel.textContent = formatCurrency(total);
    document.getElementById('hiddenTotal').value = total; // Update the hidden input
}

function formatCurrency(amount) {
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}

// Initial call to set the correct value when the page loads
document.addEventListener('DOMContentLoaded', () => {
    updateTotalPrice();
});
</script>
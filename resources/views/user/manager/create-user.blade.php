<x-app-layout>
    <div class="container">
        <h1>Create User</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="seller">Seller</option>
                    <option value="warehouse">Warehouse staff</option>
                    <option value="accountant">Accountant</option>
                    <option value="customer-service">Customer service staff</option>
                </select>
            </div>
            <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</x-app-layout>

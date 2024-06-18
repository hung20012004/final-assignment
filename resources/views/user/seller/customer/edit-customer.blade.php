<x-app-layout>
    <div class="container">
        <h1>Edit Customer</h1>
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            /
             <div class="form-group">
                <label for="name">ID:</label>
                <input type="text" name="id" id="id" class="form-control" value="{{ old('id', $customer->id) }}" readonly>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email',$customer->email) }}">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address',$customer->address) }}">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone',$customer->phone) }}">
                 @if ($errors->has('phone'))
                    <div style="color: red;">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-app-layout>
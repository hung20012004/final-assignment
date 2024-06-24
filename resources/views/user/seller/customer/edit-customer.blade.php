<x-app-layout>
      <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('customers.index'), 'label' => 'Customers'],
                    ['url' => route('customers.edit', $customer->id), 'label' => 'Edit Customer'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">

         <form action="{{ route('customers.update', $customer) }}" method="POST">
            @method('PUT')
            @csrf
             <div class="form-group">
                <label for="name">ID:</label>
                <input type="text" name="id" id="id" class="form-control" value="{{ old('id', $customer->id) }}" readonly>
                
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $customer->name) }}">
                @if ($errors->has('name'))
                                <div style="color: red;">{{ $errors->first('name') }}</div>
                            @endif
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email',$customer->email) }}">
                @foreach ($errors->get('email') as $message)
                                    <div style="color: red;">{{ $message }}</div>
                                @endforeach
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address',$customer->address) }}">
                @if ($errors->has('address'))
                                <div style="color: red;">{{ $errors->first('address') }}</div>
                            @endif
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone' , $customer->phone) }}">
                @if ($errors->has('phone'))
                                @foreach ($errors->get('phone') as $message)
                                    <div style="color: red;">{{ $message }}</div>
                                @endforeach
                            @endif
            </div>
            <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
</div>
            </div>
        </div>
    </div>
</x-app-layout>
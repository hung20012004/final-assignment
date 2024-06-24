<x-app-layout>
    <div class="container">
         <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('customers.index'), 'label' => 'Customers'],
                ['url' => route('customers.create'), 'label' => 'Create Customer'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div style="color: red;">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            @if ($errors->has('email'))    
                                @foreach ($errors->get('email') as $message)
                                    <div style="color: red;">{{ $message }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Address:</label>
                            <input type="text" name="address" id="role" class="form-control" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <div style="color: red;">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Phone:</label>
                            <input type="number" name="phone" id="role" class="form-control" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                @foreach ($errors->get('phone') as $message)
                                    <div style="color: red;">{{ $message }}</div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
     </div>
        
        @if (session('success'))
            <div class="alert alert-success mt-2" id="success-message">
                {{ session('success') }}
            </div>
        @endif
    </div>

</x-app-layout>

<script>

 @if (session('redirect'))
        // Hiển thị thông báo tạm thời
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
            window.location.href = "{{ route('customers.index') }}";
        }, 500); // 3 giây
 @endif

</script>
<x-app-layout>
    <div class="container">
        <h1>Create User</h1>
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
                <input type="tel" name="phone" id="role" class="form-control" value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                     @foreach ($errors->get('phone') as $message)
                         <div style="color: red;">{{ $message }}</div>
                     @endforeach
                @endif
            </div>
            <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        
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
        }, 3000); // 3 giây
 @endif

</script>
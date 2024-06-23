<x-app-layout>
    <div class="container">
         <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('blogs.index'), 'label' => 'Blogs'],
                ['url' => route('blogs.create'), 'label' => 'Create Blogs'],
            ]" />
        </div>
        <div class="row justify-content-center mx-1 px-1">
            <div class="col-md-12 col-lg-11 col-sm-12">
                <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                @if ($errors->has('title'))
                    <div style="color: red;">{{ $errors->first('title') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="author">User:</label>
                <select name="user_name" id="user_name" class="form-control" value="">
                    <option value=""></option>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}" {{ old('user_name') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <input type="text" name="content" id="content" class="form-control" value="{{ old('content') }}">
                @if ($errors->has('content'))
                    <div style="color: red;">{{ $errors->first('content') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
                @if ($errors->has('author'))
                     @foreach ($errors->get('author') as $message)
                         <div style="color: red;">{{ $message }}</div>
                     @endforeach
                @endif
            </div>
            <div class="form-group">
                <label for="content">Upload File:</label>
                <input type="file" name="file" id="file" class="form-control">
                @if ($errors->has('file'))
                    <div style="color: red;">{{ $errors->first('file') }}</div>
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
        }, 3000); // 3 giây
 @endif

</script>
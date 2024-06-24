<x-app-layout>
      <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('blogs.index'), 'label' => 'Blogs'],
                    ['url' => route('blogs.edit', $blog->id), 'label' => 'Edit Blog'],
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

        <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="author">User:</label>
                <input type="text" class="form-control" placeholder="{{ Auth::user()->name }}" disabled>
                <input type="text" name="user_name" id="user_name" class="form-control" value="{{ Auth::user()->id }}" hidden>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
                @endif
            </div>
             <div class="form-group">
                <label for="name">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}">
                @if ($errors->has('title'))
                    <div style="color: red;">{{ $errors->first('title') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <input type="text" name="content" id="content" class="form-control" value="{{ old('content', $blog->content) }}">
                @if ($errors->has('content'))
                    <div style="color: red;">{{ $errors->first('content') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $blog->author) }}">
                @if ($errors->has('author'))
                     @foreach ($errors->get('author') as $message)
                         <div style="color: red;">{{ $message }}</div>
                     @endforeach
                @endif
            </div>
            <div class="form-group">
                    <label for="file">File</label>
                        @if ($blog->file_path)
                            <p>Current File: <a href="{{ $blog->file_path }}">Download</a></p>
                            <input type="file" class="form-control-file mt-2" id="file" name="file">
                        @else
                        <input type="file" class="form-control-file" id="file" name="file">
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
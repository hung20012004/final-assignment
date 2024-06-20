<x-app-layout>
    <div class="container">
        <h1>Edit Customer</h1>
        <form action="{{ route('blogs.update', $blog) }}" method="POST">
            @method('PUT')
            @csrf
             <div class="form-group">
                <label for="name">Title:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}">
                @if ($errors->has('title'))
                    <div style="color: red;">{{ $errors->first('title') }}</div>
                @endif
            </div>
            <div class="form-group">
                <label for="author">User:</label>
                <select name="user_name" id="user_name" class="form-control" value="">
                    <option value="{{ $blog->user_id }}">{{ $blog->user->name }}</option>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}" {{ old('user_name', $blog->user->name) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_name'))
                    <div style="color: red;">{{ $errors->first('user_name') }}</div>
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
            <!-- Thêm các trường thông tin khác của người dùng nếu cần -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-app-layout>
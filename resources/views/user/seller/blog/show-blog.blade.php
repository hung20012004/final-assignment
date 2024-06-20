<x-app-layout>
    @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
    <div class="container">
        <h1>Blog Information</h1>
        <div>
            <p><strong>ID:</strong> {{ $blog->id }}</p>
            <p><strong>Title:</strong> {{ $blog->title }}</p>
            <p><strong>User:</strong> {{ $blog->user->name}}</p>
            <p><strong>Content:</strong> {{ $blog->content }}</p>
            <p><strong>Author:</strong> {{ $blog->author }}</p>

        </div>
    </div>
</x-app-layout>

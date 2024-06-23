
<x-app-layout>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('blogs.index'), 'label' => 'Blogs'],
                    ['url' => '', 'label' => 'Blog Details'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Details</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                         <p><strong>ID:</strong> {{ $blog->id }}</p>
            <p><strong>Title:</strong> {{ $blog->title }}</p>
            <p><strong>User:</strong> {{ $blog->user->name}}</p>
            <p><strong>Content:</strong> {{ $blog->content }}</p>
            <p><strong>Author:</strong> {{ $blog->author }}</p>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

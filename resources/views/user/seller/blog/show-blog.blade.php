
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
                        @endif <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>ID:</strong> {{ $blog->id }}
                            </li>
                            <li class="list-group-item">
                               <strong>Title:</strong> {{ $blog->title }}
                            </li>
                            <li class="list-group-item">
                                <strong>User:</strong> {{ $blog->user->name}}
                            </li>
                            <li class="list-group-item">
                              <strong>Content:</strong> {{ $blog->content }}
                            </li>
                            <li class="list-group-item">
                              <strong>File:</strong> <a href="{{ $blog->file_path }}" target="_blank"> {{ $blog->file_path }}</a>
                            </li>
                            <!-- Add any other fields you want to display here -->
                        </ul>
                       </div>
                       <div class="card-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

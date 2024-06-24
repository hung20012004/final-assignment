<x-app-layout>
    <div class="container">
         <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('blogs.index'), 'label' => 'Blogs'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Blogs Management</h5>
                            <div>
                                <a href="{{ route('blogs.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('blogs.export') }}" class="btn btn-success">Excel</a>
                                 </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                <form action="{{ route('customers.index') }}" method="GET" class="mb-3">
                     <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                     </div>
                </form>
        <div class="table-responsive">
        <table id="dataid" class="table table-bordered table-striped mt-2">
            <thead>
                <tr >
                    <th>STT</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Author</th>
                    <th>Create time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $key => $blog)
                    <tr class="item-{{ $blog->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{  Auth::user()->name }}</td>
                        <td>{{ $blog->author }}</td>
                        <td> {{ \Carbon\Carbon::parse($blog->created_at)->format('H:i d/m/Y')}}</td>
                        <td>
                            <a href="{{ route('blogs.show', $blog) }}" class="btn btn-info">View</a>
                            <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ $blog->file_path }}" class="btn btn-success" target="_blank">Download File</a>
                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteCustomer())">
                                @csrf
                                @method('DELETE')
                                <button data-id="{{ $blog->id }}" type="submit" class="btn btn-danger btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script type="text/javascript">

     $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });

    function deleteCustomer() {
        return confirm('Bạn có chắc chắn muốn xóa ?');
    };
</script>
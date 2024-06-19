<x-app-layout>
    <div class="container">
        <h1>Customers</h1>
        <div class="container col-md-12 col-lg-11 col-sm-auto px-md-3 p-3 bg-white shadow-sm mb-5 rounded mx-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('customers.export') }}" class="btn btn-success">Excel</a>
                </div>
                <form action="{{ route('customers.index') }}" method="GET" class="form-inline">
                    <input class="form-control mr-sm-2" type="search" name="searchName" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
        <table id="dataid" class="table table-bordered table-striped mt-2">
            <thead>
                <tr >
                    <th>STT</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $key => $customer)
                    <tr class="item-{{ $customer->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address}}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-info">View</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">Edit</a>
                            
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteCustomer())">
                                @csrf
                                @method('DELETE')
                                <button data-id="{{ $customer->id }}" type="submit" class="btn btn-danger btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
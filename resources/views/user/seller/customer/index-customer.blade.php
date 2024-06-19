<x-app-layout>
    <div class="container">
        <h1>Customers</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New Customer</a>
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered table-striped mt-2">
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
</x-app-layout>

<script type="text/javascript">
    function deleteCustomer() {
        return confirm('Bạn có chắc chắn muốn xóa ?');
    };
</script>
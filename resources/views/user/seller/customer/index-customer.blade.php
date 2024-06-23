<x-app-layout>
    <div class="container">
         <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('customers.index'), 'label' => 'Customers'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Customer Management</h5>
                            <div>
                                <a href="{{ route('customers.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('customers.export') }}" class="btn btn-success">Excel</a>
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
                            <input type="search" name="searchName" class="form-control" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                     </div>
                </form>
                <div class="table-responsive">
                <table id="dataid" class="table table-bordered table-striped mt-3 ">
                    <thead class="bg-light text-black text-center">
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
                                <td class="text-center">{{ $key+1 }}</td>
                                <td class="text-center">{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->address}}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-info btn-sm mx-2">View</a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm mx-2">Edit</a>
                                    
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline-block;" onsubmit="return(deleteCustomer())">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-delete btn-sm mx-2">Delete</button>
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
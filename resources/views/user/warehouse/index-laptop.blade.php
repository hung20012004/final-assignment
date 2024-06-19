<x-app-layout>
    <div class="container-fluid">
        <div class="row mx-lg-5 mx-md-0">
            <x-breadcrumb :links="[
                ['url' => route('laptops.index'), 'label' => 'Laptops'],
            ]" />
        </div>
        <div class="container col-md-12 col-lg-11 col-sm-auto px-md-3 p-3 bg-white shadow-sm mb-5 rounded mx-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('laptops.create') }}" class="btn btn-primary">New</a>
                </div>
                <form action="{{ route('laptops.index') }}" method="GET" class="form-inline">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            @if (session('success'))
                <div class="alert alert-success mt-2">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="dataid" class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laptops as $laptop)
                            <tr>
                                <td>{{ $laptop->id }}</td>
                                <td>{{ $laptop->name }}</td>
                                <td>{{ number_format($laptop->price, 0, ',', '.') }} VND</td>
                                <td>{{ $laptop->quantity }}</td>
                                <td>{{ $laptop->status }}</td>
                                <td>
                                    <a href="{{ route('laptops.show', $laptop) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('laptops.edit', $laptop) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('laptops.destroy', $laptop) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip'
            });
        });
    </script>
</x-app-layout>

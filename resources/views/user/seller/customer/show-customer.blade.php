<x-app-layout>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('customers.index'), 'label' => 'Customers'],
                    ['url' => '', 'label' => 'Customer Details'],
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
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>ID: </strong> {{ $customer->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Name: </strong> {{ $customer->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email: </strong> {{ $customer->email }}
                            </li>
                            <li class="list-group-item">
                                <strong>Phone: </strong> {{ $customer->phone }}
                            </li>
                            <li class="list-group-item">
                                <strong>Created at: </strong> {{ \Carbon\Carbon::parse($customer->created_at)->format('H:i d/m/Y')}}
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

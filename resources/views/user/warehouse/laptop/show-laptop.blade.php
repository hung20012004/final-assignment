<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('laptops.index'), 'label' => 'Laptops'],
                    ['url' => '', 'label' => 'Laptop Details'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Laptop Details</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>ID:</strong> {{ $laptop->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Name:</strong> {{ $laptop->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Manufactory:</strong> {{ $laptop->manufactory->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Category:</strong> {{ $laptop->category->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Price:</strong> {{ number_format($laptop->price, 0, ',', '.') }} VND
                            </li>
                            <li class="list-group-item">
                                <strong>Quantity:</strong> {{ $laptop->quantity }}
                            </li>
                            <li class="list-group-item">
                                <strong>Status:</strong> {{ $laptop->status }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('laptops.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

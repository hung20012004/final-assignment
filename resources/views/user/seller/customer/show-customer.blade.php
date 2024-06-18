<x-app-layout>
    @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
    <div class="container">
        <h1>Customer Information</h1>
        <div>
            <p><strong>ID:</strong> {{ $customer->id }}</p>
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Address:</strong> {{ $customer->address }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone }}</p>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Laptop Details</h1>
        <div>
            <p><strong>ID:</strong> {{ $laptop->id }}</p>
            <p><strong>Name:</strong> {{ $laptop->name }}</p>
            <p><strong>Category:</strong> {{ $laptop->category->name }}</p>
            <p><strong>Manufactory:</strong> {{ $laptop->manufactory->name }}</p>
            <p><strong>Price:</strong> {{ number_format($laptop->price, 0, ',', '.') }} VND</p>
            <p><strong>Quantity:</strong> {{ $laptop->quantity }}</p>
            <p><strong>Status:</strong>
                @if ($laptop->status == 1)
                    Còn hàng
                @elseif ($laptop->status == 0)
                    Hết hàng
                @else
                    Ngưng kinh doanh
                @endif
            </p>
        </div>
    </div>
</x-app-layout>

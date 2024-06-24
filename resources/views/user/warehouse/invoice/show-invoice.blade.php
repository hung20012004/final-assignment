<x-app-layout>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('invoices.index'), 'label' => 'Invoices'],
                    ['url' => '', 'label' => 'Invoice Details'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Invoice Details</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>ID:</strong> {{ $invoice->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Warehouse Staff:</strong> {{ $invoice->user->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Provider:</strong> {{ $invoice->provider->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Created at:</strong> {{ $invoice->created_at->format('H:i d-m-Y') }}
                            </li>
                            <li class="list-group-item">
                                <strong>Status:</strong> {{ $invoice->state == 1 ? 'Đang xử lý' : 'Đã hủy' }}
                            </li>
                        </ul>
                        <h5 class="mt-4">Laptop Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>Laptop Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0; // Initialize total price
                                    @endphp
                                    @foreach ($invoice->invoice_detail as $invoiceDetail)
                                        <tr>
                                            <td>{{ $invoiceDetail->laptop->name }}</td>
                                            <td>{{ $invoiceDetail->quantity }}</td>
                                            <td>{{ number_format($invoiceDetail->price, 0, ',', '.') }}</td>
                                            <td>{{ number_format($invoiceDetail->quantity * $invoiceDetail->price, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                            $total += $invoiceDetail->quantity * $invoiceDetail->price; // Add to total price
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><strong>Total</strong></td>
                                        <td><strong>{{ number_format($total, 0, ',', '.') }} đ</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

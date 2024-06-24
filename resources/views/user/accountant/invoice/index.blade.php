<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('accountantInvoices.index'), 'label' => 'Invoices'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Invoices</h5>
                            <div>
                                <a href="{{ route('accountantInvoices.create') }}" class="btn btn-primary">New</a>
                                <a href="{{ route('accountantInvoices.export') }}" class="btn btn-success">Export to Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('accountantInvoices.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="dataid" class="table table-bordered mt-3">
                                <thead class="bg-light text-black text-center">
                                    <tr>
                                        <th>User</th>
                                        <th>Provider</th>
                                        <th>Total Amount</th>
                                        <th>State</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->invoice_code }}</td>
                                            <td>{{ $invoice->user->name }}</td>
                                            <td>{{ $invoice->provider->name }}</td>
                                            <td>{{ $invoice->total_amount }}</td>
                                            <td>{{ $invoice->state }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('accountantInvoices.show', $invoice) }}" class="btn btn-info btn-sm mx-2">View</a>
                                                @if ($invoice->payment_status != 'Paid')
                                                    <a href="{{ route('accountantInvoices.payment', $invoice) }}" class="btn btn-success btn-sm mx-2">Pay</a>
                                                @endif
                                                <!-- Add other actions as needed -->
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
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataid').DataTable({
                dom: 'rtip',
                // Add additional DataTables configuration options if needed
            });
        });
    </script>
</x-app-layout>

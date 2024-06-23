<x-app-layout>

    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('salary.index'), 'label' => 'Salary'],
                    ['url' => '', 'label' => 'Salary Details'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Salary Details</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>ID: </strong> {{ $salary->id }}
                            </li>
                            <li class="list-group-item">
                                <strong>Staff Name: </strong> {{ $salary->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Month: </strong> {{ $salary->month }}
                            </li>
                            <li class="list-group-item">
                                <strong>Year: </strong> {{ $salary->year }}
                            </li>
                            <!-- Add any other fields you want to display here -->
                             <li class="list-group-item">
                                <strong>Base salary: </strong> {{  number_format($salary->base_salary, 0, ',', '.') }}
                            </li>
                             <li class="list-group-item">
                                <strong>Allowences: </strong> {{ number_format($salary->allowances, 0, ',', '.') }}
                            </li>
                             <li class="list-group-item">
                                <strong>Deductions: </strong> {{ number_format($salary->deductions, 0, ',', '.') }}
                            </li>
                             <li class="list-group-item">
                                <strong>Total: </strong> {{number_format( $salary->total_salary, 0, ',', '.') }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('salary.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-dark">
            {{ __('Laptop Statistics') }}
        </h2>
    </x-slot>

    <x-breadcrumb :links="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Laptop Statistics'), 'url' => '']
    ]"/>

    <div class="container mt-5">
        <!-- Laptops by Category Chart -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                {{ __('Laptops by Category') }}
            </div>
            <div class="card-body">
                <canvas id="laptopsByCategoryChart"></canvas>
            </div>
        </div>

        <!-- Laptops by Manufactory Chart -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                {{ __('Laptops by Manufactory') }}
            </div>
            <div class="card-body">
                <canvas id="laptopsByManufactoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Laptops by Category Chart
            var laptopsByCategoryCtx = document.getElementById('laptopsByCategoryChart').getContext('2d');
            var laptopsByCategoryChart = new Chart(laptopsByCategoryCtx, {
                type: 'bar',
                data: {
                    labels: @json($laptopsByCategory->pluck('name')),
                    datasets: [{
                        label: 'Number of Laptops',
                        data: @json($laptopsByCategory->pluck('laptops_count')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // This makes the chart horizontal
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Laptops by Manufactory Chart
            var laptopsByManufactoryCtx = document.getElementById('laptopsByManufactoryChart').getContext('2d');
            var laptopsByManufactoryChart = new Chart(laptopsByManufactoryCtx, {
                type: 'bar',
                data: {
                    labels: @json($laptopsByManufactory->pluck('name')),
                    datasets: [{
                        label: 'Number of Laptops',
                        data: @json($laptopsByManufactory->pluck('laptops_count')),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // This makes the chart horizontal
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bold text-dark">
            {{ __('Statistics revenue') }}
        </h2>
    </x-slot>

    <x-breadcrumb :links="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Statistics'), 'url' => '']
    ]"/>

    <div class="container mt-5">
        <!-- Top-Selling Products Chart -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                {{ __('Top-Selling Products') }}
            </div>
            <div class="card-body">
                <canvas id="topSellingProductsChart"></canvas>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                {{ __('Monthly Sales') }}
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <!-- Customer Purchase Counts Chart -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                {{ __('Customer Purchase Counts') }}
            </div>
            <div class="card-body">
                <canvas id="customerPurchaseCountsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Top-Selling Products Chart
            var topSellingProductsCtx = document.getElementById('topSellingProductsChart').getContext('2d');
            var topSellingProductsChart = new Chart(topSellingProductsCtx, {
                type: 'bar',
                data: {
                    labels: @json($topSellingProducts->pluck('name')),
                    datasets: [{
                        label: 'Total Sold',
                        data: @json($topSellingProducts->pluck('total_sold')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Monthly Sales Chart
            var monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
            var monthlySalesChart = new Chart(monthlySalesCtx, {
                type: 'line',
                data: {
                    labels: @json($monthlySales->pluck('month')),
                    datasets: [{
                        label: 'Total Sales',
                        data: @json($monthlySales->pluck('total_sales')),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Customer Purchase Counts Chart
            var customerPurchaseCountsCtx = document.getElementById('customerPurchaseCountsChart').getContext('2d');
            var customerPurchaseCountsChart = new Chart(customerPurchaseCountsCtx, {
                type: 'bar',
                data: {
                    labels: @json($customerPurchaseCounts->pluck('name')),
                    datasets: [{
                        label: 'Total Orders',
                        data: @json($customerPurchaseCounts->pluck('total_orders')),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

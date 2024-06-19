<x-app-layout>
    <div class="container mt-5">
        <h1 class="mb-4">User Statistics</h1>

        <!-- Total Users Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                Total Users
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalUsers }}</h5>
            </div>
        </div>

        <!-- Users by Role Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                Users by Role
            </div>
            <div class="card-body">
                <canvas id="usersByRoleChart"></canvas>
            </div>
        </div>

        <!-- Users Created Last Month Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                Users Created Last Month
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $usersCreatedLastMonth }}</h5>
            </div>
        </div>

        <!-- Users Created By Month Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-white">
                Users Created By Month (This Year)
            </div>
            <div class="card-body">
                <canvas id="usersCreatedByMonthChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Users by Role Chart
            var usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
            var usersByRoleChart = new Chart(usersByRoleCtx, {
                type: 'bar', // Specify the type as bar for vertical bar chart
                data: {
                    labels: @json($usersByRole->pluck('role')),
                    datasets: [{
                        label: 'Users by Role',
                        data: @json($usersByRole->pluck('total')),
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

            // Users Created By Month Chart
            var usersCreatedByMonthCtx = document.getElementById('usersCreatedByMonthChart').getContext('2d');
            var usersCreatedByMonthChart = new Chart(usersCreatedByMonthCtx, {
                type: 'bar', // Specify the type as bar for vertical bar chart
                data: {
                    labels: @json($usersCreatedByMonth->pluck('month')),
                    datasets: [{
                        label: 'Users Created',
                        data: @json($usersCreatedByMonth->pluck('total')),
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
        });
    </script>
</x-app-layout>

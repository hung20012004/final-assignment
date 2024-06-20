<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('dashboard'), 'label' => 'Dashboard']
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Tasks</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalTasks }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Completed Tasks</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $completedTasks }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Pending Tasks</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pendingTasks }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Task Statistics</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="taskChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Tasks</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>State</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ ucfirst($task->state) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($task->created_at)->format('H:i d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('usertasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('usertasks.index') }}" class="btn btn-link">View All Tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('taskChart').getContext('2d');
            var taskChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Total', 'Completed', 'Pending', 'In Progress'],
                    datasets: [{
                        data: [{{ $taskStats['total'] }}, {{ $taskStats['completed'] }}, {{ $taskStats['pending'] }}, {{ $taskStats['in_progress'] }}],
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Task Statistics'
                    }
                }
            });
        });
    </script>
</x-app-layout>

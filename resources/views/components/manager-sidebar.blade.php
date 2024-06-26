@if(Auth::user()->role=='manager')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa-solid fa-user-group"></i>
                <span>Staffs</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('users.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('tasks.index') }}">Tasks</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa-solid fa-chart-simple"></i>
                <span>&nbsp;Statistic</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('orders.statistics') }}">Revenue</a>
                    <a class="collapse-item" href="{{ route('laptops.statistics') }}">Products</a>
                    <a class="collapse-item" href="{{ route('users.statistics') }}">Staffs</a>
                    {{-- <a class="collapse-item" href="utilities-other.html">Other</a> --}}
                </div>
            </div>
        </li>
@endif

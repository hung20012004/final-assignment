@if(Auth::user()->role=='seller')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route ('customers.index') }}">
                <i class="fa-solid fa-people-group"></i>
                <span>Customers</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route ('orders.index') }}">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Orders</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fa-solid fa-money-bill-transfer"></i>
                <span>Settlement</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="sidebar-heading">
            Personal
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fa-solid fa-list-check"></i>
                <span>&nbsp;Tasks</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="utilities-color.html">New tasks</a>
                    <a class="collapse-item" href="utilities-border.html">Complete tasks</a>
                </div>
            </div>
        </li>

        @endif

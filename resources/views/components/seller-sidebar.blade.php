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


        @endif

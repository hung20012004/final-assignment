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
            <a class="nav-link" href="{{ route ('blogs.index') }}">
                <i class="fa-brands fa-blogger"></i>
                <span>Blogs</span></a>
        </li>


        @endif

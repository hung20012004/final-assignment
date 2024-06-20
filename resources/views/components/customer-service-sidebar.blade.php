@if(Auth::user()->role=='customer_sevice')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fa-solid fa-user"></i>
                    <span>Requests</span></a>
            </li>
        </li>
        <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fa-solid fa-user"></i>
                    <span>Comments</span></a>
            </li>
        </li>
        <li class="nav-item">
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fa-solid fa-user"></i>
                    <span>Products</span></a>
            </li>
        </li>
@endif

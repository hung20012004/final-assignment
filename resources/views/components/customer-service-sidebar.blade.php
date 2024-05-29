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
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span></a>
        </li>
@endif

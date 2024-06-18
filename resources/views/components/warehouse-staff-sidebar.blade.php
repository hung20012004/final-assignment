@if(Auth::user()->role=='warehouse')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProvider"
                aria-expanded="true" aria-controls="collapseProvider">
                <i class="fa-solid fa-user-group"></i>
                <span>Providers</span>
            </a>
            <div id="collapseProvider" class="collapse" aria-labelledby="headingProvider" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('users.index') }}">Management</a>
                    <a class="collapse-item" href="cards.html">Add Provider</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
                aria-expanded="true" aria-controls="collapseProduct">
                <i class="fa-solid fa-user-group"></i>
                <span>Products</span>
            </a>
            <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('laptops.index') }}">Management</a>
                    <a class="collapse-item" href="cards.html">Add Product</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fa-solid fa-user"></i>
                <span>Invoices</span>
            </a>
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

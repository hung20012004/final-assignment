@if(Auth::user()->role=='accountant')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route ('salary.index') }}">
                <i class="fa-solid fa-table"></i>
                <span>Salaries</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route ('accountantInvoice.index') }}">
                <i class="fa-solid fa-money-bill-transfer"></i>
                <span>Invoice</span></a>
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
                    <a class="collapse-item" href="utilities-color.html">Revenue</a>
                    <a class="collapse-item" href="utilities-border.html">Products</a>
                    <a class="collapse-item" href="utilities-animation.html">Staffs</a>
                    <a class="collapse-item" href="">Salaries</a>
                </div>
            </div>
        </li>

@endif

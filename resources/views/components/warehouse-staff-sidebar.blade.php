@if(Auth::user()->role=='warehouse')
        <div class="sidebar-heading">
            Apps
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('providers.index') }}">
                <i class="fa-solid fa-user-plus"></i>
                <span>Providers</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('laptops.index') }}">
                <i class="fa-solid fa-laptop"></i>
                <span>Products</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('invoices.index') }}">
                <i class="fa-solid fa-money-bill-transfer"></i>
                <span>Invoices</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="fa-solid fa-list"></i>
                <span>Category</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('manufactories.index') }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>Manufactory</span></a>
        </li>
        @endif

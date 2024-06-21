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
                    <a class="collapse-item" href="{{ route('providers.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('providers.create') }}">Add Provider</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed " href="#" data-toggle="collapse" data-target="#collapseProduct"
                aria-expanded="true" aria-controls="collapseProduct">
                <i class="fa-solid fa-user-group"></i>
                <span>Products</span>
            </a>
            <div id="collapseProduct" class="collapse" aria-labelledby="headingProduct" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('laptops.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('laptops.create') }}">Add Product</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
                aria-expanded="true" aria-controls="collapseInvoice">
                <i class="fa-solid fa-user-group"></i>
                <span>Invoices</span>
            </a>
            <div id="collapseInvoice" class="collapse" aria-labelledby="headingInvoice" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('invoices.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('invoices.create') }}">Add Invoice</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManufatory"
                aria-expanded="true" aria-controls="collapseManufatory">
                <i class="fa-solid fa-user-group"></i>
                <span>Manufactory</span>
            </a>
            <div id="collapseManufatory" class="collapse" aria-labelledby="headingManufactory" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('manufactories.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('manufactories.create') }}">Add Manufactory</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
                aria-expanded="true" aria-controls="collapseCategory">
                <i class="fa-solid fa-user-group"></i>
                <span>Category</span>
            </a>
            <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('categories.index') }}">Management</a>
                    <a class="collapse-item" href="{{ route('categories.create') }}">Add Category</a>
                </div>
            </div>
        </li>

        @endif

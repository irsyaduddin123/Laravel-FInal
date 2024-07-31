<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('admin/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/1.png') }}" style="width: 30px; height:30px" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">Geek Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/dashboard')) active @endif">
        <a class="nav-link" href="{{ url('admin/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/categories')) active @endif">
        <a class="nav-link" href="{{ url('admin/categories') }}">
            <i class="fas fa-fw fa-solid fa-list"></i>

            <span>Category</span></a>
    </li>


    <hr class="sidebar-divider">

    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/products')) active @endif">
        <a class="nav-link" href="{{ url('admin/products') }}">
            <i class="fas fa-fw fa-light fa-cart-plus"></i>
            <span>Product</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/orders')) active @endif">
        <a class="nav-link" href="{{ url('admin/orders') }}">
            <i class="fas fa-fw fa-solid fa-cart-plus"></i>
            <span>Orders And Carts</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/reedem')) active @endif">
        <a class="nav-link" href="{{ url('admin/reedem') }}">
            <i class="fas fa-fw fa-solid fa-gift"></i>
            <span>Reedem Code</span></a>
    </li>
    <hr class="sidebar-divider">

    <li class="nav-item  @if(Str::startsWith(request()->path(), 'admin/massage')) active @endif">
        <a class="nav-link" href="{{ url('admin/massage') }}">
            <i class="fas fa-fw fa-light fa-envelope"></i>
            <span>User Message</span></a>
    </li>


    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

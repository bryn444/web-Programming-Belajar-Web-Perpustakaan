<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">E-Library UNM</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{ request()->is('admin/master/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('admin/master/*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open nav-icon"></i>
                    <p>
                        Data Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview bg-secondary">
                    <li class="nav-item">
                        <a href="{{ route('admin.master.kategori.index') }}"
                            class="nav-link {{ request()->is('admin/master/kategori') ? 'active' : '' }}">
                            <i class="fas fa-solid fa-list nav-icon"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.buku.index') }}"
                            class="nav-link {{ Request::segment(3) == 'buku' ? 'active' : '' }}">
                            <i class="fas fa-solid fa-book nav-icon"></i>
                            <p>Buku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.user.index') }}"
                            class="nav-link {{ request()->is('admin/master/user') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <p>User</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Profile Dropdown Menu -->
    <li class="nav-item dropdown">
        <a data-mdb-dropdown-init class="nav-link dropdown-toggle d-flex align-items-center" href="#"
            id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
            <b>{{ Auth::user()->nama }}</b> &nbsp;&nbsp;
            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded-circle" height="40"
                width="40" alt="Avatar" loading="lazy" />
        </a>
        <div class="dropdown-menu" style="width: 100%; margin-top: 10px;">
            <a class="dropdown-item" href="{{ route('admin.profil') }}"><i class="fas fa-solid fa-user nav-icon"></i>&nbsp; Profil Saya</a>
            <a class="dropdown-item" href="{{ route('admin.ganti-password') }}"><i class="fas fa-solid fa-lock nav-icon"></i>&nbsp; Ganti Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt nav-icon"></i>&nbsp; Logout</a>
        </div>
    </li>
</ul>
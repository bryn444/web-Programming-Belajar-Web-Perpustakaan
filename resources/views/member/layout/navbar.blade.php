<nav class="navbar navbar-expand navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">E-Library <b>UNM</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02"
            aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample02">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item {{ Request::segment(2) == 'data-keranjang' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('member.dataKeranjang', auth()->user()->id) }}">Keranjang
                            <span class="badge badge-danger">
                                {{ Auth::user()->totalKeranjang() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'data-booking' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('member.dataBooking', auth()->user()->id) }}">Booking
                            <span class="badge badge-primary">
                                {{ Auth::user()->totalBooking() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'sedang-pinjam' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('member.sedangPinjam', auth()->user()->id) }}">Sedang Pinjam
                            <span class="badge badge-light">
                                {{ Auth::user()->totalSedangPinjam() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'riwayat-pinjam' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('member.riwayatPinjam', auth()->user()->id) }}">Riwayat Peminjaman
                            <span class="badge badge-success">
                                {{ Auth::user()->totalRiwayatPinjam() }}
                            </span>
                        </a>
                    </li>
                @endauth
            </ul>
            <form class="form-inline my-2 my-md-0">
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a data-mdb-dropdown-init class="nav-link dropdown-toggle d-flex align-items-center"
                                href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                <b>{{ Auth::user()->nama }} </b> &nbsp;&nbsp;
                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                    class="rounded-circle profil-img" alt="Avatar" loading="lazy" />
                            </a>
                            <div class="dropdown-menu" style="width: 100%; margin-top: 10px;">
                                <a class="dropdown-item" href="{{ route('member.profil') }}"><i class="fas fa-solid fa-user nav-icon"></i>&nbsp; Profil Saya</a>
                                <a class="dropdown-item" href="{{ route('member.ganti-password') }}"><i class="fas fa-solid fa-lock nav-icon"></i>&nbsp; Ganti Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt nav-icon"></i>&nbsp;
                                    Logout</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i>&nbsp; Login</a>
                        </li>
                    @endauth
                </ul>
            </form>
        </div>
    </div>
</nav>

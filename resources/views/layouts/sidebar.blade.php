    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo" style="display: flex; align-items: center; padding-left: 8px;">
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset=""
                                style="width: 100%; max-width: 160px; height: auto; display: block;">
                        </a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul class="menu">
                    @if (Auth::user()->role === 'admin')
                        <li class="sidebar-title">Admin</li>

                        <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.index') }}" class='sidebar-link'>
                                <i class="bi bi-tags"></i>
                                <span>Kategori</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}" class='sidebar-link'>
                                <i class="bi bi-box-seam"></i>
                                <span>Produk</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Akun Kasir</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-title">Kasir</li>


                    <li class="sidebar-item {{ request()->routeIs('kasir.pos') ? 'active' : '' }}">
                        <a href="{{ route('kasir.pos') }}" class='sidebar-link'>
                            <i class="bi bi-cart-check"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>

                    @if (Auth::user()->role === 'admin')
                        <li class="sidebar-item {{ request()->routeIs('kasir.history') ? 'active' : '' }}">
                            <a href="{{ route('kasir.history') }}" class='sidebar-link'>
                                <i class="bi bi-clock-history"></i>
                                <span>Riwayat Transaksi</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="sidebar-link"
                                style="background: none; border: none; width: 100%; text-align: left;">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>


                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>

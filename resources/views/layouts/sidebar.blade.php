<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/LogoFIx.png') }}" class="navbar-brand" height="85">
            </a>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- ================= ADMIN ================= --}}
                @if (auth()->user()->role_id == 1)
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('events.index') }}">
                            <i class="fas fa-calendar"></i>
                            <p>Manajemen Event</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                @endif


                {{-- ================= ORGANIZER ================= --}}
                @if (auth()->user()->role_id == 2)
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-chart-line"></i>
                            <p>Penjualan Tiket</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-calendar"></i>
                            <p>Event Saya</p>
                        </a>
                    </li>
                @endif


                {{-- ================= USER ================= --}}
                @if (auth()->user()->role_id == 3)
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-calendar"></i>
                            <p>Event</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-ticket-alt"></i>
                            <p>Tiket Saya</p>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>

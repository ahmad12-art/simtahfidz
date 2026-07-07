<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIMTAHFIDZ</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="app-body {{ session('dark_mode') ? 'dark-mode' : '' }}">

    <nav class="topbar d-flex align-items-center justify-content-between px-3">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
            <a href="{{ route('dashboard') }}" class="brand d-flex align-items-center gap-2 text-decoration-none">
                <span class="brand-icon"><i class="bi bi-book-half"></i></span>
                <span class="brand-text d-none d-sm-inline">SIMTAHFIDZ</span>
            </a>
        </div>

        <form class="search-box d-none d-md-flex" role="search">
            <i class="bi bi-search"></i>
            <input type="search" placeholder="Cari santri, guru, kelas..." class="form-control form-control-sm border-0">
        </form>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-icon" id="darkModeToggle" title="Mode Gelap">
                <i class="bi bi-moon-stars"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-sm btn-icon position-relative" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="notif-dot"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-2" style="width:300px;">
                    <p class="small text-muted px-2 mb-1">Notifikasi Terbaru</p>
                    <div class="dropdown-item small text-wrap">Belum ada notifikasi baru.</div>
                </div>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center gap-2 border-0 bg-transparent" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : asset('img/default-avatar.png') }}"
                         class="avatar-sm" alt="avatar" onerror="this.src='https://ui-avatars.com/api/?background=059669&color=fff&name={{ urlencode(auth()->user()->name) }}'">
                    <span class="d-none d-md-inline small fw-semibold">{{ auth()->user()->name }}</span>
                    <i class="bi bi-caret-down-fill small"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil Saya</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="app-shell">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-scroll">
                <p class="sidebar-heading">Menu Utama</p>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
                </a>

                @if(auth()->user()->isAdmin())
                <p class="sidebar-heading">Data Master</p>
                <a href="{{ route('guru.index') }}" class="sidebar-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i><span>Guru</span>
                </a>
                <a href="{{ route('santri.index') }}" class="sidebar-link {{ request()->routeIs('santri.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Santri</span>
                </a>
                <a href="{{ route('kelas.index') }}" class="sidebar-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i><span>Kelas</span>
                </a>
                <a href="{{ route('surah.index') }}" class="sidebar-link {{ request()->routeIs('surah.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i><span>Surah</span>
                </a>
                @else
                <p class="sidebar-heading">Data</p>
                <a href="{{ route('santri.index') }}" class="sidebar-link {{ request()->routeIs('santri.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Santri</span>
                </a>
                @endif

                <p class="sidebar-heading">Kegiatan Hafalan</p>
                <a href="{{ route('target-hafalan.index') }}" class="sidebar-link {{ request()->routeIs('target-hafalan.*') ? 'active' : '' }}">
                    <i class="bi bi-bullseye"></i><span>Target Hafalan</span>
                </a>
                <a href="{{ route('setoran.index') }}" class="sidebar-link {{ request()->routeIs('setoran.*') ? 'active' : '' }}">
                    <i class="bi bi-mic"></i><span>Setoran Hafalan</span>
                </a>
                <a href="{{ route('murajaah.index') }}" class="sidebar-link {{ request()->routeIs('murajaah.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-repeat"></i><span>Murajaah</span>
                </a>
                <a href="{{ route('penilaian.index') }}" class="sidebar-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i><span>Penilaian</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span>
                </a>

                @if(auth()->user()->isAdmin())
                <p class="sidebar-heading">Administrasi</p>
                <a href="{{ route('user.index') }}" class="sidebar-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i><span>User</span>
                </a>
                <a href="{{ route('log-aktivitas.index') }}" class="sidebar-link {{ request()->routeIs('log-aktivitas.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i><span>Log Aktivitas</span>
                </a>
                <a href="{{ route('pengaturan.edit') }}" class="sidebar-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i><span>Pengaturan</span>
                </a>
                @endif

                <p class="sidebar-heading">Akun</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i><span>Profil</span>
                </a>
            </div>
        </aside>

        <main class="main-content">
            <div class="page-wrapper">
                @if(!isset($hideBreadcrumb))
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb small mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
                @endif

                <x-flash-message />

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>

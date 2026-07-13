<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul ?? 'VitaGuard Admin' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            background-color: #f4f6f9;
        }        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #1c2b4a;
            color: #cfd8e3;
            overflow-y: auto;
            z-index: 1030;
            transition: transform .3s ease;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1rem 1.2rem;
            color: #fff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.15rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand:hover { color: #fff; }
        .sidebar .nav-section-title {
            text-transform: uppercase;
            font-size: .7rem;
            letter-spacing: .05em;
            color: #6f83a3;
            padding: 1rem 1.2rem .35rem;
        }
        .sidebar .nav-link {
            color: #cfd8e3;
            padding: .6rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .92rem;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: rgba(13,110,253,.18);
            color: #fff;
            border-left-color: #4d8dff;
            font-weight: 600;
        }
        .sidebar .nav-link i { font-size: 1.05rem; width: 1.2rem; text-align: center; }        
        .topbar {
            margin-left: var(--sidebar-width);
            background: #fff;
            border-bottom: 1px solid #e6e9ee;
            padding: .65rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .sidebar-toggle-btn {
            display: none;
        }
        .content-wrapper {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: calc(100vh - 130px);
        }
        footer.app-footer {
            margin-left: var(--sidebar-width);
            text-align: center;
            color: #8a94a3;
            padding: 1rem;
            font-size: .85rem;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar, .content-wrapper, footer.app-footer { margin-left: 0; }
            .sidebar-toggle-btn { display: inline-flex; }
        }
    </style>
</head>

<body>

    @php
        $role = Auth::user()->role;
        $dashboardRoute = $role === 'dokter' ? route('dokter.dashboard') : route('admin.dashboard');
        $current = Route::currentRouteName();
    @endphp

    <aside class="sidebar" id="appSidebar">
        <a href="{{ $dashboardRoute }}" class="sidebar-brand">
            <i class="bi bi-heart-pulse-fill"></i> VitaGuard
        </a>

        <nav class="nav flex-column py-2">
            @if($role === 'dokter')
                <div class="nav-section-title">Menu Dokter</div>
                <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ $current === 'dokter.dashboard' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('dokter.bookings') }}" class="nav-link {{ $current === 'dokter.bookings' ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Booking Konsultasi
                </a>
            @else
                <div class="nav-section-title">Menu Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $current === 'admin.dashboard' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="nav-section-title">Data Master</div>
                <a href="{{ route('doctors.index') }}" class="nav-link {{ str_starts_with($current, 'doctors.') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> Dokter
                </a>
                <a href="{{ route('members.index') }}" class="nav-link {{ str_starts_with($current, 'members.') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Member
                </a>
                <a href="{{ route('articles.index') }}" class="nav-link {{ str_starts_with($current, 'articles.') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i> Artikel Kesehatan
                </a>

                <div class="nav-section-title">Konsultasi</div>
                <a href="{{ route('consultations.index') }}" class="nav-link {{ $current === 'consultations.index' ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text"></i> Data Konsultasi
                </a>
                <a href="{{ route('consultations.trashed') }}" class="nav-link {{ $current === 'consultations.trashed' ? 'active' : '' }}">
                    <i class="bi bi-trash"></i> Arsip Konsultasi
                </a>

                <div class="nav-section-title">Sistem</div>
                <a href="{{ route('account.index') }}" class="nav-link {{ str_starts_with($current, 'account.') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i> Akun Pengguna
                </a>
            @endif
        </nav>
    </aside>


    <div class="topbar">
        <button class="btn btn-outline-secondary sidebar-toggle-btn" type="button" id="sidebarToggleBtn">
            <i class="bi bi-list"></i>
        </button>

        <span class="fw-semibold text-secondary">{{ $judul ?? 'VitaGuard Admin' }}</span>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">
                <i class="bi bi-person-circle me-1"></i>
                Halo, {{ Auth::user()->name }} <span class="badge bg-secondary">{{ $role }}</span>
            </span>
            <form action="{{ route('logout') }}" method="post" class="d-inline m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
    
    <main class="content-wrapper">
        @yield('content')

        @stack('modals')
    </main>

    <footer class="app-footer">
        <small>VitaGuard &copy; 2026</small>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('sidebarToggleBtn')?.addEventListener('click', function () {
            document.getElementById('appSidebar').classList.toggle('show');
        });
    </script>

    @stack('script')
</body>

</html>
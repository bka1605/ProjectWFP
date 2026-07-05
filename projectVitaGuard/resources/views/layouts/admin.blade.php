<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul ?? 'VitaGuard Admin' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">VitaGuard</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVitaGuard"
                aria-controls="navbarVitaGuard" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarVitaGuard">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- ========================================================== --}}
                    {{-- TAMBAHAN BARU: MENU NAVBAR KHUSUS UNTUK DOKTER             --}}
                    {{-- ========================================================== --}}
                    @if(Auth::user()->role === 'dokter')
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-warning" href="{{ route('home') }}">Dashboard Dokter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#konsultasi-aktif">Konsultasi Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#riwayat-konsultasi">Riwayat & Pasien</a>
                        </li>

                    {{-- ========================================================== --}}
                    {{-- KODE ASLI TEMAN ANDA: MENU NAVBAR KHUSUS UNTUK ADMIN       --}}
                    {{-- ========================================================== --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services.index') }}">Services</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.showExpensiveService') }}">Report</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctors.index') }}">Doctors</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('articles.index') }}">Articles</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('transactions.index') }}">Transactions</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('members.index') }}">Members</a>
                        </li>
                    @endif

                </ul> 
                
                <span class="navbar-text text-white me-3">
                    Halo, {{ Auth::user()->name }} ({{ Auth::user()->role }})
                </span>

                <form action="{{ route('logout') }}" method="post" class="d-inline">
                    @csrf
                    <input type="submit" value="Logout" class='btn btn-danger btn-sm' />
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')

        @stack('modals')
    </main>

    <footer class="text-center text-muted py-4">
        <small>VitaGuard &copy; 2026</small>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    @stack('script')
</body>

</html>
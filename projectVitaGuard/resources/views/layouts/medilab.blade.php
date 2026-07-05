<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $judul ?? 'VitaGuard - Medical Services' }}</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">

  <style>
    body { font-family: "Open Sans", sans-serif; color: #444444; }
    a { color: #1977cc; text-decoration: none; transition: 0.5s; }
    a:hover { color: #3291e6; }
    #topbar { background: #fff; height: 40px; font-size: 14px; transition: all 0.5s; border-bottom: 1px solid #eee; }
    #header { background: #fff; transition: all 0.5s; z-index: 997; padding: 15px 0; border-bottom: 1px solid #eceff2; }
    .navbar a { color: #627680; padding: 10px 0 10px 30px; font-size: 15px; font-weight: 500; }
    .navbar a:hover, .navbar .active { color: #1977cc; }
    .appointment-btn { margin-left: 25px; background: #1977cc; color: #fff; border-radius: 50px; padding: 8px 25px; white-space: nowrap; transition: 0.3s; font-size: 14px; display: inline-block; }
    .appointment-btn:hover { background: #166ab5; color: #fff; }
    #footer { background: #f1f7fd; padding: 30px 0; color: #444444; font-size: 14px; margin-top: 50px; }
  </style>
</head>

<body>

  <div id="topbar" class="d-flex align-items-center fixed-top-disabled">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:support@vitaguard.com" class="ms-1 me-3">support@vitaguard.com</a>
        <i class="bi bi-phone"></i> <span class="ms-1">+1 5589 55488 55</span>
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <span class="badge bg-info text-dark">Member Panel</span>
      </div>
    </div>
  </div>

  <header id="header" class="sticky-top">
    <div class="container d-flex align-items-center">
      <h1 class="logo me-auto fs-3 font-weight-bold mb-0"><a href="{{ route('member.dashboard') }}">VitaGuard</a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul class="d-flex list-unstyled mb-0 gap-3">
          <li><a class="nav-link {{ Request::routeIs('member.dashboard') ? 'active' : '' }}" href="{{ route('member.dashboard') }}">Dashboard</a></li>
          <li><a class="nav-link {{ Request::routeIs('member.doctors*') ? 'active' : '' }}" href="{{ route('member.doctors') }}">Daftar Dokter</a></li>
          <li><a class="nav-link {{ Request::routeIs('member.articles*') ? 'active' : '' }}" href="{{ route('member.articles') }}">Artikel</a></li>
          
          {{-- PERUBAHAN DI SINI: Menyambungkan menu ke route member.history dan memberi class active --}}
          <li><a class="nav-link {{ Request::routeIs('member.history') ? 'active' : '' }}" href="{{ route('member.history') }}">Riwayat Konsultasi</a></li>
        </ul>
      </nav>

      <a href="{{ route('logout') }}" class="appointment-btn scrollto" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         Logout
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
    </div>
  </header>

  <main id="main" class="py-5">
    @yield('content')
  </main>

  <footer id="footer">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        &copy; Copyright <strong><span>Medilab & VitaGuard</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by BootstrapMade & Kelompok 3
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>
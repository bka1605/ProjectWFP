<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - VitaGuard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --teal:#0B4F4A;
            --mint:#EEF5F1;
            --coral:#FF6F5E;
            --gold:#F2B134;
            --navy:#16282A;
        }
        body{ font-family:'Inter', sans-serif; color:var(--navy); background:var(--mint); }
        h1, h4, .brand-font{ font-family:'Sora', sans-serif; }

        .vg-navbar{ background:#fff; border-bottom:1px solid rgba(11,79,74,0.08); }
        .vg-logo{ font-weight:800; font-size:1.3rem; color:var(--teal); }
        .vg-logo i{ color:var(--coral); margin-right:.4rem; }

        .btn-vg-outline{ border:1.5px solid var(--teal); color:var(--teal); font-weight:600; border-radius:50px; padding:.5rem 1.4rem; }
        .btn-vg-outline:hover{ background:var(--teal); color:#fff; }
        .btn-vg-solid{ background:var(--coral); color:#fff; font-weight:600; border:none; border-radius:50px; padding:.5rem 1.5rem; }
        .btn-vg-solid:hover{ background:#e85a49; color:#fff; }

        .hero-title{ font-weight:800; font-size:2.5rem; color:var(--teal); }
        .hero-sub{ color:#4B5E5C; max-width:540px; margin:0 auto; }

        .vg-card{
            background:#fff; border-radius:20px; border:1px solid rgba(11,79,74,0.06);
            box-shadow:0 6px 16px rgba(11,79,74,0.06);
            transition: transform .25s ease, box-shadow .25s ease;
            border-top:4px solid var(--accent, var(--teal));
        }
        .vg-card:hover{ transform:translateY(-6px); box-shadow:0 16px 28px rgba(11,79,74,0.12); }

        .icon-wrapper{
            height:70px; width:70px; display:flex; align-items:center; justify-content:center;
            border-radius:18px; margin:0 auto 1.1rem auto;
            background:color-mix(in srgb, var(--accent, var(--teal)) 12%, white);
            color:var(--accent, var(--teal));
        }
        .vg-card h4{ font-weight:700; }
        .btn-card{ border:none; border-radius:50px; font-weight:600; padding:.6rem 1rem; color:#fff; background:var(--accent, var(--teal)); }
        .btn-card:hover{ filter:brightness(1.08); color:#fff; }

        .card-teal{ --accent:var(--teal); }
        .card-gold{ --accent:var(--gold); }
        .card-coral{ --accent:var(--coral); }

        footer{ background:#fff; border-top:1px solid rgba(11,79,74,0.08); }
        .btn-admin{ border:1.5px solid #cfd8d6; color:#6b7674; border-radius:50px; font-weight:600; padding:.45rem 1.3rem; font-size:.85rem; }
        .btn-admin:hover{ background:#f1f3f2; color:var(--navy); }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-md vg-navbar py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand vg-logo" href="{{ url('menu') }}">
                <i class="fa-solid fa-shield-heart"></i>VitaGuard
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#vgNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="vgNav">
                <div class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-0">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/menu') }}" class="btn btn-vg-solid">
                                <i class="fa-solid fa-user me-1"></i> Akun Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-vg-outline">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-vg-solid">
                                    <i class="fa-solid fa-user-plus me-1"></i> Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5 flex-grow-1 d-flex flex-column justify-content-center">

        <div class="text-center mb-5">
            <h1 class="hero-title mb-3">Pilih Layanan Kami</h1>
            <p class="hero-sub">Akses berbagai layanan kesehatan digital VitaGuard dengan mudah dan cepat.</p>
        </div>

        <div class="row justify-content-center g-4">

            <div class="col-lg-4 col-md-6">
                <div class="vg-card card-teal h-100 text-center p-4">
                    <div class="icon-wrapper"><i class="fa-solid fa-stethoscope fa-2x"></i></div>
                    <h4>Layanan Kesehatan</h4>
                    <p class="text-muted mb-4">Lihat dan pilih layanan medis yang Anda butuhkan di klinik kami.</p>
                    <a href="{{ url('services') }}" class="btn btn-card w-100">Buka Layanan</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="vg-card card-gold h-100 text-center p-4">
                    <div class="icon-wrapper"><i class="fa-regular fa-newspaper fa-2x"></i></div>
                    <h4>Artikel Kesehatan</h4>
                    <p class="text-muted mb-4">Baca tips dan berita terbaru seputar dunia kesehatan terkini.</p>
                    <a href="{{ url('articles') }}" class="btn btn-card w-100">Baca Artikel</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="vg-card card-coral h-100 text-center p-4">
                    <div class="icon-wrapper"><i class="fa-solid fa-user-doctor fa-2x"></i></div>
                    <h4>Daftar Dokter</h4>
                    <p class="text-muted mb-4">Temukan dokter spesialis terbaik untuk konsultasi medis Anda.</p>
                    <a href="{{ url('doctors') }}" class="btn btn-card w-100">Lihat Dokter</a>
                </div>
            </div>

        </div>
    </div>

    <footer class="py-4 mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="text-muted mb-0 fw-medium">&copy; 2026 VitaGuard. All rights reserved.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-admin">
                <i class="fa-solid fa-lock me-1"></i> Admin Panel
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
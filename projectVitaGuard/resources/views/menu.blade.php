<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Menu - VitaGuard</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center fw-bold mb-5">Pilih Layanan Kami</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Lihat Daftar Layanan</h4>
                        <p class="text-muted">Informasi tentang layanan kesehatan.</p>
                        <a href="{{ url('services') }}" class="btn btn-primary w-100">Buka Layanan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Artikel Kesehatan</h4>
                        <p class="text-muted">Informasi terkini tentang kesehatan.</p>
                        <a href="{{ url('articles') }}" class="btn btn-success w-100">Buka Layanan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Lihat Daftar Dokter</h4>
                        <p class="text-muted">Informasi tentang Dokter.</p>
                        <a href="{{ url('doctors') }}" class="btn btn-danger w-100">Buka Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer style="position: absolute; bottom: 0; width: 100%; margin-bottom: 2.5%;">
    <div class="container py-3">
        <p class="text-center text-muted">&copy; 2023 VitaGuard. All rights reserved.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">
            Admin
        </a>
    </div>
</footer>

</html>
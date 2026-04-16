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
                        <h4>Lihat Category</h4>
                        <p class="text-muted">Informasi tentang kategori layanan.</p>
                        <a href="{{ url('services') }}" class="btn btn-info w-100">Buka</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Lihat Daftar Member</h4>
                        <p class="text-muted">Informasi tentang member.</p>
                        <a href="{{ url('articles') }}" class="btn btn-warning w-100">Buka</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Lihat Daftar Transaksi</h4>
                        <p class="text-muted">Informasi tentang transaksi.</p>
                        <a href="{{ url('doctors') }}" class="btn btn-secondary w-100">Buka</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer style="position: absolute; bottom: 0; width: 100%; margin-bottom: 2.5%;">
    <div class="container py-3">
        <p class="text-center text-muted">&copy; 2023 VitaGuard. All rights reserved.</p>
        <a href="{{ url('menu') }}" style="position: absolute; left: 50%; transform: translateX(-50%);">Kembali</a>
    </div>
</footer>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>VitaGuard - Home</title>
</head>
<body>
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active bg-primary text-white vh-100 d-flex align-items-center">
                <div class="container text-center">
                    <h1 class="display-3 fw-bold">Konsultasi Dokter Online</h1>
                    <p class="lead">Solusi kesehatan digital tanpa harus keluar rumah.</p>
                </div>
            </div>
            <div class="carousel-item bg-success text-white vh-100 d-flex align-items-center">
                <div class="container text-center">
                    <h1 class="display-3 fw-bold">Janji Temu Cepat</h1>
                    <p class="lead">Booking jadwal dokter di Rumah Sakit pilihan Anda dengan instan.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container text-center" style="margin-top: -100px; position: relative; z-index: 10;">
        <a href="{{ url('/welcome') }}" class="btn btn-light btn-lg shadow px-5 rounded-pill fw-bold text-primary">Masuk ke Portal</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
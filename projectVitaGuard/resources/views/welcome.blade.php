<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VitaGuard - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="position-relative">
        <div id="heroCarousel" class="carousel slide" data-bs-interval="false">
            <div class="carousel-indicators mb-4">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active bg-primary text-white min-vh-100">
                    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center text-center">
                        <h1 class="display-3 fw-bold">Konsultasi Dokter Online</h1>
                        <p class="lead">Solusi kesehatan digital tanpa harus keluar rumah.</p>
                    </div>
                </div>

                <div class="carousel-item bg-success text-white min-vh-100">
                    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center text-center">
                        <h1 class="display-3 fw-bold">Janji Temu Cepat</h1>
                        <p class="lead">Booking jadwal dokter di Rumah Sakit pilihan Anda dengan instan.</p>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-5 z-3">
            <a href="{{ url('/welcome') }}" class="btn btn-light btn-lg shadow px-5 rounded-pill fw-bold text-primary">
                Masuk ke Portal
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
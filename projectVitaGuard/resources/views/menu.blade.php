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
                        <h4>Konsultasi Online</h4>
                        <p class="text-muted">Chat langsung dengan dokter spesialis.</p>
                        <a href="{{ url('/menu/konsultasi') }}" class="btn btn-primary w-100">Buka Layanan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center p-4">
                    <div class="card-body">
                        <h4>Janji Temu Dokter</h4>
                        <p class="text-muted">Reservasi jadwal di Klinik/Rumah Sakit.</p>
                        <a href="{{ url('/menu/janji') }}" class="btn btn-success w-100">Buka Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin - VitaGuard</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white p-3">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kategori</th>
                            <th>Status Layanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#CAT-01</td>
                            <td>Konsultasi Umum</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        </tr>
                        <tr>
                            <td>#CAT-02</td>
                            <td>Spesialis</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        </tr>
                        <tr>
                            <td>#CAT-03</td>
                            <td>Pemeriksaan Laboratorium</td>
                            <td><span class="badge bg-info">Tersedia</span></td>
                            <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
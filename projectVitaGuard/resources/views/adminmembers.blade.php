<!DOCTYPE html>
<html lang="en">
<head>
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
                            <th>Nama Pasien</th>
                            <th>Status Member</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Budi Santoso</td>
                            <td><span class="badge bg-info">Premium</span></td>
                            <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Siti Aminah</td>
                            <td><span class="badge bg-secondary">Reguler</span></td>
                            <td><button class="btn btn-sm btn-warning">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $judul }}</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">{{ $judul }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Spesialisasi</th>
                            <th>No. Telepon</th>
                            <th>Lama Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->nama }}</td>
                                <td>{{ $doctor->spesialisasi }}</td>
                                <td>{{ $doctor->nomor_telepon }}</td>
                                <td>{{ $doctor->lama_kerja }} tahun</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('menu') }}" class="btn btn-outline-primary">Kembali ke Menu</a>
                
            </div>
        </div>
    </div>
</body>
</html>
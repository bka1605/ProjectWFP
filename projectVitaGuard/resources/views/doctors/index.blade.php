@extends('layouts.admin')

@section('content')

    @if(Auth::user()->role === 'dokter')

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard Dokter VitaGuard</h5>

                <a href="{{ route('dokter.bookings') }}"
                    class="btn btn-light btn-sm fw-bold text-success rounded-pill shadow-sm" style="cursor: pointer;">
                    <i class="bi bi-bell-fill"></i> Kelola Antrean Booking
                </a>
            </div>
            <div class="card-body text-center py-4">
                <h3>Selamat Datang, {{ $dokter->nama ?? Auth::user()->name }}!</h3>
                <p class="text-muted mb-0">Spesialisasi: {{ $dokter->spesialisasi ?? 'Belum Diatur' }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Profil Medis Saya</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('dokter.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Dokter</label>
                        <input type="text" name="nama" class="form-control" value="{{ $dokter->nama ?? Auth::user()->name }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Spesialisasi</label>
                        <input type="text" name="spesialisasi" class="form-control" value="{{ $dokter->spesialisasi ?? '' }}"
                            placeholder="Contoh: Spesialis Anak" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ $dokter->nomor_telepon ?? '' }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lama Kerja (Tahun)</label>
                        <input type="number" name="lama_kerja" class="form-control" value="{{ $dokter->lama_kerja ?? '' }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4" id="konsultasi-aktif">
            <div class="card-header bg-warning text-dark fw-bold">
                <h5 class="mb-0">🔴 Daftar Konsultasi Aktif / Berlangsung</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Booking</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Konsultasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($konsultasiAktif as $konsultasi)
                                <tr>
                                    <td><strong>#{{ $konsultasi->id }}</strong></td>
                                    <td>{{ $konsultasi->user->name ?? 'Pasien Umum' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($konsultasi->created_at)->format('d M Y - H:i') }} WIB</td>
                                    <td>
                                        <span class="badge bg-warning text-dark text-uppercase">
                                            {{ $konsultasi->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-success">
                                            Hubungi Pasien
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Tidak ada jadwal konsultasi aktif saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4" id="riwayat-konsultasi">
            <div class="card-header bg-secondary text-white fw-bold">
                <h5 class="mb-0">✅ Riwayat Konsultasi & Daftar Pasien</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>No. Booking</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Selesai</th>
                                <th>Status Medis</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatConsultasi ?? $riwayatKonsultasi as $riwayat)
                                <tr>
                                    <td>#{{ $riwayat->id }}</td>
                                    <td><strong>{{ $riwayat->user->name ?? 'Pasien Selesai' }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->updated_at)->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-success text-uppercase">
                                            {{ $riwayat->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted text-sm">Konsultasi Selesai Diarsip</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada riwayat konsultasi pasien yang selesai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-bold mb-1">{{ $judul }}</h2>
                <p class="text-muted mb-0">Daftar dokter yang tersedia pada platform VitaGuard.</p>
            </div>

            <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
                Lihat Services
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>Nomor Telepon</th>
                            <th>Lama Kerja</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->nama }}</td>
                                <td>{{ $doctor->spepsialisasi }}</td>
                                <td>{{ $doctor->nomor_telepon }}</td>
                                <td>{{ $doctor->lama_kerja }} tahun</td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm">Edit</a>

                                    @can('delete-permission', Auth::user())
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data dokter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
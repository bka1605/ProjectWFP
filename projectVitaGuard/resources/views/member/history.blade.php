@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="fw-bold text-dark border-bottom pb-2">📜 Riwayat Konsultasi Medis</h3>
            <p class="text-muted">Berikut adalah catatan rekam medis dan riwayat percakapan konsultasi yang pernah Anda lakukan di VitaGuard.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3" style="width: 5%;">No</th>
                            <th class="py-3">Tanggal Konsultasi</th>
                            <th class="py-3">Dokter Spesialis</th>
                            <th class="py-3">Status Medis</th>
                            <th class="text-center py-3" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $index => $row)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    {{ $row->created_at ? $row->created_at->format('d M Y - H:i') : 'Hari ini' }} WIB
                                </td>
                                <td class="fw-semibold text-dark">
                                    {{-- Mengambil nama dokter dari relasi atau fallback teks jika kosong --}}
                                    {{ $row->doctor->nama ?? $row->dokter->nama ?? 'Tim Medis VitaGuard' }}
                                </td>
                                <td>
                                    @if(in_array($row->status, ['completed', 'selesai', 'success']))
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Selesai</span>
                                    @elseif(in_array($row->status, ['active', 'pending', 'berlangsung']))
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split"></i> Berlangsung</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">{{ ucfirst($row->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    {{-- Hanya ada tombol Lihat/Detail, tidak ada tombol hapus --}}
                                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-eye"></i> Lihat Chat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan Dummy Pengisi Data jika tabel transaksi kelompok Anda masih kosong --}}
                            <tr>
                                <td class="text-center ps-4 fw-bold text-muted">1</td>
                                <td><i class="bi bi-calendar-event text-primary me-2"></i> 05 Jul 2026 - 14:20 WIB</td>
                                <td class="fw-semibold text-dark">dr. Martino</td>
                                <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Selesai</span></td>
                                <td class="text-center"><button class="btn btn-outline-primary btn-sm rounded-pill px-3" disabled><i class="bi bi-eye"></i> Detail</button></td>
                            </tr>
                            <tr>
                                <td class="text-center ps-4 fw-bold text-muted">2</td>
                                <td><i class="bi bi-calendar-event text-primary me-2"></i> 03 Jul 2026 - 09:15 WIB</td>
                                <td class="fw-semibold text-dark">dr. Kane Kulas</td>
                                <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Selesai</span></td>
                                <td class="text-center"><button class="btn btn-outline-primary btn-sm rounded-pill px-3" disabled><i class="bi bi-eye"></i> Detail</button></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 shadow-sm mt-4 rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-shield-lock-fill fs-4 me-3 text-info"></i>
        <div class="small">
            <strong>Keamanan Sistem:</strong> Sesuai dengan regulasi rekam medis elektronik, seluruh riwayat konsultasi yang telah disimpan bersifat permanen dan **tidak dapat dihapus** oleh pihak pasien demi validitas riwayat kesehatan Anda.
        </div>
    </div>
</div>
@endsection
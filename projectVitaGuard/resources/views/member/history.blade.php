@extends('layouts.medilab')

@section('content')
    <div class="container mt-5 pt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="fw-bold text-dark border-bottom pb-2">📜 Riwayat Aktivitas Medis</h3>
                <p class="text-muted">Berikut adalah catatan riwayat booking jadwal konsultasi dan transaksi layanan Anda di VitaGuard.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h5 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-calendar-check"></i> Booking & Jadwal Konsultasi</h5>
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-5">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-primary">
                            <tr>
                                <th class="ps-4 py-3" style="width: 5%;">No</th>
                                <th class="py-3">Jadwal Konsultasi</th>
                                <th class="py-3">Dokter Spesialis</th>
                                <th class="py-3">Status</th>
                                <th class="text-center py-3" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index => $row)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <i class="bi bi-clock-history text-primary me-2"></i>
                                        {{ \Carbon\Carbon::parse($row->jadwal)->format('d M Y - H:i') }} WIB
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        dr. {{ $row->doctor->nama ?? 'Tim Medis VitaGuard' }}
                                    </td>
                                    <td>
                                        @if($row->status == 'completed')
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Selesai</span>
                                        @elseif($row->status == 'accepted')
                                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><i class="bi bi-chat-dots-fill"></i> Siap Konsultasi</span>
                                        @elseif($row->status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        @if($row->status == 'accepted')
                                            <a href="#" class="btn btn-primary btn-sm rounded-pill px-3">
                                                <i class="bi bi-chat-text"></i> Mulai Chat
                                            </a>
                                        @elseif($row->status == 'completed')
                                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                                <i class="bi bi-eye"></i> Lihat Chat
                                            </a>
                                        @else
                                            <button class="btn btn-light text-muted btn-sm rounded-pill px-3" disabled>
                                                Belum Tersedia
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat booking konsultasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-success mb-3"><i class="bi bi-receipt"></i> Transaksi Layanan Medis</h5>
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-success text-success">
                            <tr>
                                <th class="ps-4 py-3" style="width: 5%;">No</th>
                                <th class="py-3">Tanggal Transaksi</th>
                                <th class="py-3">Layanan / Dokter</th>
                                <th class="py-3">Status Pembayaran</th>
                                <th class="text-center py-3" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $index => $trx)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <i class="bi bi-calendar-event text-success me-2"></i>
                                        {{ $trx->created_at ? $trx->created_at->format('d M Y - H:i') : 'Hari ini' }} WIB
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ $trx->doctor->nama ?? $trx->dokter->nama ?? 'Layanan Medis VitaGuard' }}
                                    </td>
                                    <td>
                                        @if(in_array($trx->status, ['completed', 'selesai', 'success']))
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Lunas / Selesai</span>
                                        @elseif(in_array($trx->status, ['proses', 'berlangsung', 'pending']))
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split"></i> Diproses</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">{{ ucfirst($trx->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <button class="btn btn-outline-success btn-sm rounded-pill px-3">
                                            <i class="bi bi-file-earmark-text"></i> Invoice
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat transaksi layanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm mt-5 rounded-3 d-flex align-items-center" role="alert">
            <i class="bi bi-shield-lock-fill fs-4 me-3 text-info"></i>
            <div class="small">
                <strong>Keamanan Sistem:</strong> Sesuai dengan regulasi rekam medis elektronik, seluruh riwayat konsultasi dan transaksi yang telah disimpan bersifat permanen dan **tidak dapat dihapus** oleh pihak pasien.
            </div>
        </div>
    </div>
@endsection
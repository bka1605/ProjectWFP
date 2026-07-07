@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h3 class="fw-bold text-dark border-bottom pb-2">Docs Tim Dokter Spesialis VitaGuard</h3>
            <p class="text-muted">Silakan pilih dokter spesialis terbaik kami untuk mulai melakukan konsultasi medis.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($doctors as $doc)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="p-4 bg-light text-center border-bottom">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <i class="bi bi-person-pulse"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $doc->nama }}</h5>
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">{{ $doc->spesialisasi }}</span>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div class="mb-3">
                            <table class="table table-sm table-borderless text-muted small mb-0">
                                <tr>
                                    <td style="width: 40%;">Pengalaman</td>
                                    <td>: <strong>{{ $doc->lama_kerja }} Tahun</strong></td>
                                </tr>
                                <tr>
                                    <td>No. Telepon</td>
                                    <td>: {{ $doc->nomor_telepon }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('member.doctors.profile', $doc->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Profil Lengkap</a>
                            <button class="btn btn-primary btn-sm rounded-pill">Mulai Chat Konsultasi</button>
                            <a href="{{ route('member.booking.create', $doc->id) }}" class="btn btn-primary rounded-pill btn-sm">Booking Jadwal</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-warning text-center border-0 py-4">
                    <i class="bi bi-exclamation-triangle fs-3"></i>
                    <p class="mb-0 mt-2">Maaf, saat ini tidak ada data dokter yang tersedia.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
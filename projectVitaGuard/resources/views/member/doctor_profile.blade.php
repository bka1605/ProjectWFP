@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('member.doctors') }}" class="btn btn-light btn-sm text-muted rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Dokter
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 rounded-3 h-100 d-flex flex-column justify-content-center align-items-center">
                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 100px; height: 100px; font-size: 3rem;">
                    <i class="bi bi-person-md"></i>
                </div>
                
                <h4 class="fw-bold text-dark mb-1">{{ $dokter->nama }}</h4>
                <p class="text-primary fw-medium mb-3">{{ $dokter->spesialisasi }}</p>
                
                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill"></i> Terverifikasi Ikatan Dokter</span>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 rounded-3 h-100">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">📄 Informasi & Kualifikasi Medis</h5>
                
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="text-muted small d-block mb-1">Nama Lengkap</label>
                        <span class="fw-bold text-dark fs-5">{{ $dokter->nama }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block mb-1">Bidang Spesialisasi</label>
                        <span class="fw-bold text-dark fs-5">{{ $dokter->spesialisasi }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block mb-1">Pengalaman Praktik</label>
                        <span class="fw-bold text-dark fs-5">{{ $dokter->lama_kerja }} Tahun</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block mb-1">Nomor Kontak Medis</label>
                        <span class="fw-bold text-dark fs-5">{{ $dokter->nomor_telepon }}</span>
                    </div>
                </div>

                <hr class="my-4">

                <div class="bg-light p-3 rounded-3 border-start border-primary border-4">
                    <h6 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle"></i> Catatan Pasien</h6>
                    <p class="text-muted small mb-0">Dokter ini aktif melayani sesi konsultasi online via chat. Seluruh riwayat percakapan medis dilindungi oleh kode etik kedokteran dan tersimpan aman di database rahasia pasien.</p>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                        <i class="bi bi-chat-text"></i> Hubungi Dokter Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
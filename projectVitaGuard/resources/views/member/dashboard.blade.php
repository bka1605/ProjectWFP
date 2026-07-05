@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="p-5 mb-4 bg-light rounded-3 border-start border-primary border-5 shadow-sm">
                <div class="container-fluid py-3">
                    <h1 class="display-5 fw-bold text-dark">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="col-md-8 fs-5 text-muted">Selamat datang di platform layanan kesehatan modern VitaGuard. Silakan akses menu di atas untuk melakukan konsultasi medis terpercaya, membaca info kesehatan, atau melihat riwayat medis Anda.</p>
                    <a href="{{ route('member.doctors') }}" class="btn btn-primary btn-lg rounded-pill px-4">Mulai Konsultasi</a>
                </div>
            </div>
            
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <div class="icon-box mb-3 text-primary fs-1"><i class="bi bi-person-badge"></i></div>
                            <h5 class="card-title fw-bold">Daftar Dokter</h5>
                            <p class="card-text text-muted small">Temukan tim dokter spesialis terbaik kami yang siap mendengarkan keluhan kesehatan Anda.</p>
                            <a href="{{ route('member.doctors') }}" class="btn btn-link p-0 text-decoration-none">Lihat Dokter &rarr;</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <div class="icon-box mb-3 text-primary fs-1"><i class="bi bi-journal-text"></i></div>
                            <h5 class="card-title fw-bold">Artikel Kesehatan</h5>
                            <p class="card-text text-muted small">Kumpulan informasi, tips, serta rujukan medis valid yang ditulis langsung oleh para pakar.</p>
                            <a href="{{ route('member.articles') }}" class="btn btn-link p-0 text-decoration-none">Baca Artikel &rarr;</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <div class="icon-box mb-3 text-primary fs-1"><i class="bi bi-clock-history"></i></div>
                            <h5 class="card-title fw-bold">Riwayat Konsultasi</h5>
                            <p class="card-text text-muted small">Pantau kembali catatan rekam medis serta hasil konsultasi chat yang pernah Anda lakukan.</p>
                            <a href="{{ route('member.history') }}" class="btn btn-link p-0 text-decoration-none">Lihat Riwayat &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
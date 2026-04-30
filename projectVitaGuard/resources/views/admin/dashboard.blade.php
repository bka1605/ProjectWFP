@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted mb-0">
            Pilih menu administrasi untuk mengelola data VitaGuard.
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Services</h5>
                    <p class="card-text text-muted">
                        Lihat daftar layanan kesehatan.
                    </p>
                    <a href="{{ route('services.index') }}" class="btn btn-primary">
                        Buka Services
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Categories</h5>
                    <p class="card-text text-muted">
                        Lihat kategori layanan kesehatan.
                    </p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">
                        Buka Categories
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Report</h5>
                    <p class="card-text text-muted">
                        Lihat report service termahal per kategori.
                    </p>
                    <a href="{{ route('category.showExpensiveService') }}" class="btn btn-primary">
                        Buka Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Doctors</h5>
                    <p class="card-text text-muted">
                        Lihat daftar dokter.
                    </p>
                    <a href="{{ route('doctors.index') }}" class="btn btn-outline-primary">
                        Buka Doctors
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Articles</h5>
                    <p class="card-text text-muted">
                        Lihat daftar artikel kesehatan.
                    </p>
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">
                        Buka Articles
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Members</h5>
                    <p class="card-text text-muted">
                        Lihat daftar member/pasien.
                    </p>
                    <a href="{{ route('members.index') }}" class="btn btn-outline-primary">
                        Buka Members
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
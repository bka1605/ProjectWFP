@extends('layouts.admin')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <h4 class="mb-3">Forbidden Access</h4>
    <p class="text-muted mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Kembali</a>
    <a href="{{ route('home') }}" class="btn btn-primary mt-2">Ke Beranda</a>
</div>
@endsection
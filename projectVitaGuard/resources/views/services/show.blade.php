@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted mb-0">Detail layanan kesehatan.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $service->service_name }}</h5>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{ $service->id }}</p>
            <p><strong>Category:</strong> {{ $service->category->category_name ?? '-' }}</p>
            <p><strong>Description:</strong> {{ $service->description }}</p>
            <p><strong>Availability:</strong> {{ $service->availability }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($service->price, 0, ',', '.') }}</p>
        </div>

        <div class="card-footer">
            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
@endsection
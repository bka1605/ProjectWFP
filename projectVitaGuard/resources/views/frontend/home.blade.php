@extends('layouts.frontend')

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold">Layanan Kesehatan Kami</h2>
        <p class="text-muted">Pilih layanan yang kamu butuhkan, lalu tambahkan ke cart.</p>
    </div>

    <div class="row gx-4 gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">

        @forelse ($datas as $data)
            <div class="col">
                <div class="card card-service h-100 shadow-sm">

                    <img src="https://dummyimage.com/600x300/dee2e6/6c757d.jpg&text={{ urlencode($data->service_name) }}"
                        class="card-img-top" alt="{{ $data->service_name }}"
                        style="height: 180px; object-fit: cover; border-radius: 12px 12px 0 0;">

                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1">{{ $data->service_name }}</h5>
                        <span class="badge bg-info text-dark mb-2">
                            {{ $data->category->category_name ?? '-' }}
                        </span>
                        <p class="text-muted small mb-2">{{ Str::limit($data->description, 80) }}</p>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-clock me-1"></i>{{ $data->availability }}
                        </p>
                    </div>

                    <div
                        class="card-footer bg-transparent border-top-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary fs-5">
                            Rp {{ number_format($data->price, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('detailService', $data->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada service tersedia.</div>
            </div>
        @endforelse

    </div>

@endsection
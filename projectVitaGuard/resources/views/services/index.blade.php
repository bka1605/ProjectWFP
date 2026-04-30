@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar layanan kesehatan yang tersedia di VitaGuard.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
            Lihat Categories
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Availability</th>
                        <th>Price</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none fw-semibold">
                                    {{ $service->service_name }}
                                </a>
                            </td>
                            <td>{{ $service->description }}</td>
                            <td>{{ $service->availability }}</td>
                            <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td>{{ $service->category->category_name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
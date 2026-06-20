@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <a href="{{ route('services.create') }}" class="btn btn-primary">+ New Service</a>
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
                        <th>Action</th>
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
                            <td>
                                <a href="{{ route('services.show', $service->id) }}"
                                   class="btn btn-info btn-sm text-white">Detail</a>
                                
                                <a href="{{ route('services.edit', $service->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>
                                
                                <form method="POST" action="{{ route('services.destroy', $service->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin hapus service {{ $service->service_name }}?')">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Report service dengan harga paling mahal pada setiap category.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            Kembali ke Categories
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID Category</th>
                        <th>Category Name</th>
                        <th>Most Expensive Service</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php
                            $expensiveService = $category->services->first();
                        @endphp

                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $expensiveService->service_name ?? '-' }}</td>
                            <td>
                                @if ($expensiveService)
                                    Rp {{ number_format($expensiveService->price, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
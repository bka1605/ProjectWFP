@extends('layouts.frontend')

@section('content')

    <div class="mb-3">
        <a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Home
        </a>
    </div>

    <div class="row g-4">

        <div class="col-md-5">
            <img src="https://dummyimage.com/600x450/dee2e6/6c757d.jpg&text={{ urlencode($data->service_name) }}"
                class="img-fluid rounded shadow-sm w-100" alt="{{ $data->service_name }}">
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <span class="badge bg-info text-dark mb-2">
                        {{ $data->category->category_name ?? '-' }}
                    </span>

                    <h3 class="fw-bold mb-2">{{ $data->service_name }}</h3>

                    <p class="text-muted mb-3">{{ $data->description }}</p>

                    <ul class="list-unstyled mb-3">
                        <li class="mb-1">
                            <i class="bi bi-clock text-primary me-2"></i>
                            <strong>Jadwal:</strong> {{ $data->availability }}
                        </li>
                        <li>
                            <i class="bi bi-tag text-primary me-2"></i>
                            <strong>Harga:</strong>
                            <span class="fs-5 fw-bold text-primary">
                                Rp {{ number_format($data->price, 0, ',', '.') }}
                            </span>
                        </li>
                    </ul>

                    <hr>

                    <form method="POST" action="{{ route('putCart', $data->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-semibold">
                                <i class="bi bi-123 me-1"></i>Jumlah
                            </label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1"
                                style="width: 120px;">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cart-plus me-1"></i>Tambah ke Cart
                        </button>

                        <a href="{{ url('/cart') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-cart3 me-1"></i>Lihat Cart
                        </a>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
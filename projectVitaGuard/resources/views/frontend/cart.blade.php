@extends('layouts.frontend')

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-cart3 me-2"></i>Cart Saya
        </h2>
        <p class="text-muted">Review pilihan layanan kamu sebelum checkout.</p>
    </div>

    @if (count($cart) > 0)

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th class="ps-4">Nama Service</th>
                                    <th class="text-center">Harga Satuan</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $r)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">{{ $r['service']->service_name }}</div>
                                            <small class="text-muted">{{ $r['service']->category->category_name ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($r['service']->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $r['quantity'] }}</span>
                                        </td>
                                        <td class="text-center fw-bold text-primary">
                                            Rp {{ number_format($r['service']->price * $r['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('detailService', $r['id']) }}"
                                                class="btn btn-sm btn-outline-secondary me-1">
                                                <i class="bi bi-pencil"></i> Ubah Qty
                                            </a>
                                            <form action="{{ route('deleteCart', $r['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus service ini dari cart?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ringkasan Order</h5>

                        @php
                            $grandTotal = 0;
                            foreach ($cart as $r) {
                                $grandTotal += (int)$r['service']->price * $r['quantity'];
                            }
                        @endphp

                        @foreach ($cart as $r)
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">{{ $r['service']->service_name }} x{{ $r['quantity'] }}</span>
                                <span>Rp {{ number_format((int)$r['service']->price * $r['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>Total</span>
                            <span class="text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('checkout') }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-bag-check me-1"></i>Checkout Sekarang
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning small mb-3">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Kamu harus login untuk checkout.
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login untuk Checkout
                            </a>
                        @endauth

                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-1"></i>Tambah Service Lagi
                        </a>
                    </div>
                </div>
            </div>

        </div>

    @else

        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #dee2e6;"></i>
            <h4 class="mt-3 text-muted">Cart kamu masih kosong</h4>
            <p class="text-muted">Yuk pilih layanan kesehatan yang kamu butuhkan.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-2">
                <i class="bi bi-house-door me-1"></i>Lihat Layanan
            </a>
        </div>

    @endif

@endsection
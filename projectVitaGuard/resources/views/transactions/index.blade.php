@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar transaksi konsultasi dan layanan VitaGuard.</p>
        </div>

        <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
            Lihat Services
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->nama_pembeli }}</td>
                            <td>{{ $transaction->tanggal_transaksi }}</td>
                            <td>
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($transaction->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
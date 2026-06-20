@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar transaksi layanan kesehatan VitaGuard.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ New Transaksi</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Services</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->user->name ?? '-' }}</td>
                            <td>
                                @forelse ($transaction->services as $service)
                                    <span class="badge bg-primary mb-1">{{ $service->service_name }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td>{{ $transaction->tanggal_transaksi }}</td>
                            <td>
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transactions.edit', $transaction->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin hapus transaksi #{{ $transaction->id }}?')">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
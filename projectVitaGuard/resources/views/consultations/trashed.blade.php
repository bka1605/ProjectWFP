@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Arsip Konsultasi</h3>
            <p class="text-muted">Data yang telah diarsipkan (Soft Deleted).</p>
        </div>
        
        <a href="{{ route('consultations.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>Dokter</th>
                            <th>Member</th>
                            <th>Tanggal Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->doctor->nama ?? 'N/A' }}</td>
                            <td>{{ $booking->member->name ?? 'N/A' }}</td>
                            <td>{{ $booking->deleted_at ? $booking->deleted_at->format('d M Y, H:i') : '-' }}</td>
                            <td>
                                <form action="{{ route('consultations.restore', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Tidak ada data di dalam arsip.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
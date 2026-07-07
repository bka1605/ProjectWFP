@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-list-check"></i> Kelola Antrean Booking Masuk</h3>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Jadwal Diminta</th>
                            <th class="py-3">Nama Pasien / Member</th>
                            <th class="py-3">Status Saat Ini</th>
                            <th class="text-center py-3">Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td class="ps-4 text-muted fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <i class="bi bi-clock me-1 text-primary"></i> 
                                    {{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y - H:i') }} WIB
                                </td>
                                <td class="fw-semibold">
                                    {{-- Mengambil nama dari tabel users berdasarkan member_id secara aman --}}
                                    {{ \App\Models\User::find($booking->member_id)->name ?? 'Member ID: '.$booking->member_id }}
                                </td>
                                <td>
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                    @elseif($booking->status == 'accepted')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">Accepted</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('dokter.bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Terima</button>
                                        </form>
                                        <form action="{{ route('dokter.bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Tolak</button>
                                        </form>
                                    @elseif($booking->status == 'accepted')
                                        <a href="#" class="btn btn-sm btn-primary rounded-pill px-3"><i class="bi bi-chat-dots"></i> Mulai Chat</a>
                                        <form action="{{ route('dokter.bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline mt-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">Selesai</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Sudah diarsipkan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada permintaan jadwal konsultasi masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
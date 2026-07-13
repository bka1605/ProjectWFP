@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Manajemen Data Konsultasi</h3>
                <p class="text-muted">Daftar rekapitulasi seluruh sesi konsultasi.</p>
            </div>

            <a href="{{ route('consultations.trashed') }}" class="btn btn-outline-secondary">
                <i class="bi bi-archive me-1"></i> Lihat Arsip
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Dokter</th>
                                <th>Member (Pasien)</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-semibold">
                                        <i class="bi bi-person-badge me-1 text-primary"></i>
                                        {{ $booking->doctor->nama ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="bi bi-person me-1 text-secondary"></i>
                                        {{ $booking->member->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y, H:i') }}
                                    </td>
                                    <td>
                                        {{-- Badge Status yang menampilkan warna sesuai status --}}
                                        @php
                                            $color = match ($booking->status) {
                                                'completed' => 'bg-success',
                                                'accepted' => 'bg-primary',
                                                'rejected' => 'bg-danger',
                                                default => 'bg-warning',
                                            };
                                        @endphp

                                        <span class="badge {{ $color }} rounded-pill px-3 py-2">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info"
                                            onclick="editStatus('{{ $booking->id }}', '{{ $booking->status }}')">
                                            Edit
                                        </button>

                                        <form action="{{ route('consultations.destroy', $booking->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Arsipkan konsultasi ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Tidak ada data konsultasi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- modal edit --}}
<div class="modal fade" id="modalEditStatus" tabindex="-1">
    <div class="modal-dialog">
        <form id="editStatusForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Status Konsultasi</h5>
                </div>
                <div class="modal-body">
                    <select name="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function editStatus(id, currentStatus) {
        $('#editStatusForm').attr('action', '/consultations/' + id + '/update');
        $('#modalEditStatus select[name="status"]').val(currentStatus);
        $('#modalEditStatus').modal('show');
    }
</script>
@extends('layouts.admin')

@section('content')

    @if(Auth::user()->role === 'dokter')

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard Dokter VitaGuard</h5>
            </div>
            <div class="card-body text-center py-4">
                <h3>Selamat Datang, {{ $dokter->nama ?? Auth::user()->name }}!</h3>
                <p class="text-muted mb-0">Spesialisasi: {{ $dokter->spesialisasi ?? 'Belum Diatur' }}</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Profil Medis Saya</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('dokter.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Dokter</label>
                        <input type="text" name="nama" class="form-control" value="{{ $dokter->nama ?? Auth::user()->name }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Spesialisasi</label>
                        <input type="text" name="spesialisasi" class="form-control" value="{{ $dokter->spesialisasi ?? '' }}"
                            placeholder="Contoh: Spesialis Anak" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ $dokter->nomor_telepon ?? '' }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lama Kerja (Tahun)</label>
                        <input type="number" name="lama_kerja" class="form-control" value="{{ $dokter->lama_kerja ?? '' }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4" id="konsultasi-aktif">
            <div class="card-header bg-info text-light fw-bold d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Konsultasi Aktif / Berlangsung</h5>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th class="ps-4 py-3">No</th>
                                <th class="py-3">Jadwal Diminta</th>
                                <th class="py-3">Nama Pasien / Member</th>
                                <th class="py-3">Status Saat Ini</th>
                                <th class="text-center py-3">Aksi Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $noAktif = 1; @endphp
                            @forelse($bookings->whereIn('status', ['pending', 'accepted']) as $booking)
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">{{ $noAktif++ }}</td>
                                    <td>
                                        <i class="bi bi-clock me-1 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y - H:i') }} WIB
                                    </td>
                                    <td class="fw-semibold">
                                        {{ \App\Models\User::find($booking->member_id)->name ?? 'Member ID: ' . $booking->member_id }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                        @elseif($booking->status == 'accepted')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Accepted</span>
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
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Tolak jadwal ini?')">Tolak</button>
                                            </form>
                                        @elseif($booking->status == 'accepted')
                                            <a href="{{ route('consultation.show', $booking->id) }}" class="btn btn-sm btn-primary rounded-pill px-3"><i class="bi bi-chat-dots"></i> Mulai Chat</a>
                                            <form action="{{ route('dokter.bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline mt-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="return confirm('Akhiri sesi konsultasi ini?')">Selesai</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada permintaan jadwal konsultasi aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PATCH #2: Riwayat Konsultasi dengan Relasi Member dan Link Riwayat Percakapan --}}
        <div class="card shadow-sm border-0 mt-4" id="riwayat-konsultasi">
            <div class="card-header bg-primary text-white fw-bold">
                <h5 class="mb-0">✅ Riwayat Konsultasi & Daftar Pasien</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>No. Booking</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Selesai</th>
                                <th>Status Medis</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $noRiwayat = 1; @endphp
                            @forelse($bookings->whereIn('status', ['completed', 'rejected']) as $booking)
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">{{ $noRiwayat++ }}</td>
                                    <td>
                                        <i class="bi bi-clock me-1 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($booking->jadwal)->format('d M Y - H:i') }} WIB
                                    </td>
                                    <td class="fw-semibold">
                                        {{ \App\Models\User::find($booking->member_id)->name ?? 'Member ID: ' . $booking->member_id }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        @if($booking->status == 'completed')
                                            <a href="{{ route('consultation.show', $booking->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="bi bi-eye"></i> Lihat Chat</a>
                                        @else
                                            <span class="text-muted small">Ditolak / Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat konsultasi pasien.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div> 
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div>
                <h2 class="fw-bold mb-1">{{ $judul }}</h2>
                <p class="text-muted mb-0">Daftar dokter yang tersedia pada platform VitaGuard.</p>
            </div>

            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalCreateDoctor">
                <i class="bi bi-plus-lg"></i> Tambah Dokter
            </button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Dokter</th>
                            <th>Spesialisasi</th>
                            <th>Nomor Telepon</th>
                            <th>Lama Kerja</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td>{{ $doctor->nama }}</td>
                                <td>{{ $doctor->spesialisasi }}</td>
                                <td>{{ $doctor->nomor_telepon }}</td>
                                <td>{{ $doctor->lama_kerja }} tahun</td>
                                <td>
                                    <button type="button" class="btn btn-info text-white btn-sm" onclick="showEditModal({{ $doctor->id }})">Edit</button>

                                    <form method="POST" action="{{ route('doctors.destroy', $doctor->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus dokter ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data dokter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- modal edit dokter --}}

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Edit Dokter</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body" id="modalContent">Memuat...</div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
    function showEditModal(id) {
        $('#modalContent').html('Memuat...');
        $.ajax({
            type: 'POST',
            url: '{{ route("doctors.getEditForm") }}',
            data: { '_token': '{{ csrf_token() }}', 'id': id },
            success: function(data) { $('#modalContent').html(data.msg); $('#modalEdit').modal('show'); }
        });
    }
    </script>
    @endpush

    {{-- modal tambah dokter --}}

    <div class="modal fade" id="modalCreateDoctor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Dokter Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('doctors.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Dokter <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="spesialisasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lama Kerja (Tahun) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="lama_kerja" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
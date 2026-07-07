@extends('layouts.medilab')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Booking Konsultasi</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Dokter Tujuan: <strong>{{ $doctor->nama }}</strong></h5>
                        <p class="text-muted">Spesialisasi: {{ $doctor->spesialisasi }}</p>
                    </div>

                    @if(isset($existingBooking) && $existingBooking)
                        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4">
                            <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning"></i>
                            <div>
                                <strong>Perhatian!</strong> Anda sudah memiliki jadwal aktif pada <br>
                                <span class="badge bg-warning text-dark mt-1 fs-6">{{ \Carbon\Carbon::parse($existingBooking->jadwal)->format('d M Y - H:i') }} WIB</span><br>
                                <small class="text-muted mt-2 d-block">Memilih jadwal baru di bawah ini akan <strong>mengubah (reschedule)</strong> jadwal Anda sebelumnya.</small>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('member.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        
                        <div class="mb-4">
                            <label for="jadwal" class="form-label fw-semibold">Pilih Tanggal & Waktu Konsultasi Baru</label>
                            <input type="datetime-local" class="form-control form-control-lg @error('jadwal') is-invalid @enderror" 
                                id="jadwal" name="jadwal" 
                                value="{{ isset($existingBooking) ? \Carbon\Carbon::parse($existingBooking->jadwal)->format('Y-m-d\TH:i') : '' }}" required>
                            @error('jadwal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg fw-bold {{ isset($existingBooking) && $existingBooking ? 'btn-warning' : 'btn-success' }}">
                                <i class="bi bi-calendar-check"></i> 
                                {{ isset($existingBooking) && $existingBooking ? 'Konfirmasi Reschedule' : 'Konfirmasi Booking' }}
                            </button>
                            <a href="{{ route('member.doctors') }}" class="btn btn-light btn-lg text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('jadwal').addEventListener('click', function(e) {
        this.showPicker();
    });
</script>
@endsection
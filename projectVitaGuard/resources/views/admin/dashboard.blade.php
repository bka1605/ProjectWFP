@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="bi bi-person-badge fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Dokter</div>
                        <div class="fw-bold fs-4">{{ $stats['total_dokter'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="bi bi-people fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Member</div>
                        <div class="fw-bold fs-4">{{ $stats['total_member'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 rounded p-3">
                        <i class="bi bi-newspaper fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Artikel</div>
                        <div class="fw-bold fs-4">{{ $stats['total_artikel'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 rounded p-3">
                        <i class="bi bi-calendar-check fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Booking</div>
                        <div class="fw-bold fs-4">{{ $stats['total_booking'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 rounded p-3">
                        <i class="bi bi-chat-dots fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Konsultasi Berlangsung</div>
                        <div class="fw-bold fs-4">{{ $stats['konsultasi_berlangsung'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 rounded p-3">
                        <i class="bi bi-check-circle fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Konsultasi Selesai</div>
                        <div class="fw-bold fs-4">{{ $stats['konsultasi_selesai'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Statistik Sistem</h6>
            <canvas id="statsChart" height="80"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('statsChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Dokter', 'Member', 'Artikel', 'Booking', 'Konsultasi Aktif', 'Konsultasi Selesai'],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                    {{ $stats['total_dokter'] }},
                    {{ $stats['total_member'] }},
                    {{ $stats['total_artikel'] }},
                    {{ $stats['total_booking'] }},
                    {{ $stats['konsultasi_berlangsung'] }},
                    {{ $stats['konsultasi_selesai'] }},
                    ],
                    backgroundColor: [
                        '#0d6efd33', '#19875433', '#ffc10733',
                        '#0dcaf033', '#0d6efd33', '#19875433'
                    ],
                    borderColor: [
                        '#0d6efd', '#198754', '#ffc107',
                        '#0dcaf0', '#0d6efd', '#198754'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    </script>
@endpush
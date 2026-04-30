@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar dokter yang tersedia pada platform VitaGuard.</p>
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
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Nomor Telepon</th>
                        <th>Lama Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->id }}</td>
                            <td>{{ $doctor->nama }}</td>
                            <td>{{ $doctor->spepsialisasi }}</td>
                            <td>{{ $doctor->nomor_telepon }}</td>
                            <td>{{ $doctor->lama_kerja }} tahun</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data dokter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
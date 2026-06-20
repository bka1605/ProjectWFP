@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted mb-0">Ubah data transaksi.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="user_id" class="form-label fw-semibold">Member / Pasien <span class="text-danger">*</span></label>
                    <select class="form-select @error('user_id') is-invalid @enderror"
                            id="user_id" name="user_id">
                        <option value="" disabled>-- Pilih Member --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Services <span class="text-danger">*</span></label>
                    <small class="text-muted d-block mb-2">Centang satu atau lebih service.</small>
                    @error('service_ids')
                        <div class="alert alert-danger py-1 px-2 mb-2">{{ $message }}</div>
                    @enderror
                    <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;">
                        @foreach ($services as $service)
                            <div class="form-check mb-1">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="service_ids[]"
                                       id="service_{{ $service->id }}"
                                       value="{{ $service->id }}"
                                       {{ in_array($service->id, old('service_ids', $selectedServiceIds)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="service_{{ $service->id }}">
                                    {{ $service->service_name }}
                                    <span class="text-muted">— Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tanggal_transaksi" class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <input type="datetime-local"
                           class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                           id="tanggal_transaksi" name="tanggal_transaksi"
                           value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('Y-m-d\TH:i')) }}">
                    @error('tanggal_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status">
                        <option value="pending"   {{ old('status', $transaction->status) == 'pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">Update Transaksi</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
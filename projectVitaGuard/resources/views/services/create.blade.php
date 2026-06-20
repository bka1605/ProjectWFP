@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted mb-0">Tambahkan layanan kesehatan baru ke VitaGuard.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('services.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="service_name" class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('service_name') is-invalid @enderror"
                           id="service_name"
                           name="service_name"
                           value="{{ old('service_name') }}"
                           placeholder="Nama layanan">
                    @error('service_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description"
                              name="description"
                              rows="3"
                              placeholder="Deskripsi layanan">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="availability" class="form-label fw-semibold">Availability <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('availability') is-invalid @enderror"
                           id="availability"
                           name="availability"
                           value="{{ old('availability') }}"
                           placeholder="Contoh: 08:00 - 17:00">
                    @error('availability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Price (Rp) <span class="text-danger">*</span></label>
                    <input type="number"
                           class="form-control @error('price') is-invalid @enderror"
                           id="price"
                           name="price"
                           value="{{ old('price') }}"
                           min="0"
                           placeholder="Contoh: 150000">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('category_id') is-invalid @enderror"
                            id="category_id"
                            name="category_id">
                        <option value="" disabled selected>-- Pilih Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Service</button>
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
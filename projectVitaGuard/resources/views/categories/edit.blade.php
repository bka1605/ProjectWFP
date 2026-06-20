@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <h2 class="fw-bold mb-1">{{ $judul }}</h2>
        <p class="text-muted mb-0">Ubah data category.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="category_name" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('category_name') is-invalid @enderror"
                           id="category_name"
                           name="category_name"
                           value="{{ old('category_name', $category->category_name) }}">
                    @error('category_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Gambar (opsional)</label>
                    @if ($category->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                 class="img-thumbnail" style="max-height: 120px;"
                                 alt="{{ $category->category_name }}">
                            <small class="d-block text-muted mt-1">Gambar saat ini. Upload baru untuk mengganti.</small>
                        </div>
                    @endif
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">Update Category</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
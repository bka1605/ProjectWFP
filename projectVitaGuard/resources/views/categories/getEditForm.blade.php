<h5 class="mb-3">Update Category</h5>

<form method="POST" action="{{ route('categories.update', $data->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="edit_category_name" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
        <input type="text"
               class="form-control"
               id="edit_category_name"
               name="category_name"
               value="{{ $data->category_name }}"
               placeholder="Nama kategori"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Gambar Saat Ini</label>
        @if ($data->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $data->image) }}"
                     class="img-thumbnail" style="max-height: 100px;"
                     alt="{{ $data->category_name }}">
            </div>
        @else
            <p class="text-muted small">Belum ada gambar.</p>
        @endif
        <input type="file" class="form-control" name="image" accept="image/*">
        <small class="text-muted">Upload baru untuk mengganti gambar lama.</small>
    </div>

    <button type="submit" class="btn btn-warning w-100">Update Category</button>
</form>
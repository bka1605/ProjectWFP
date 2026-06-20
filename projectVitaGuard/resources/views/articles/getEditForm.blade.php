<h5 class="mb-3">Update Artikel (Type A)</h5>

<form method="POST" action="{{ route('articles.update', $data->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="judul" value="{{ $data->judul }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="kategori" value="{{ $data->kategori }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Tanggal Publish <span class="text-danger">*</span></label>
        <input type="date" class="form-control" name="tanggal_publish" value="{{ $data->tanggal_publish }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
        <textarea class="form-control" name="konten" rows="4" required>{{ $data->konten }}</textarea>
    </div>

    <button type="submit" class="btn btn-warning w-100">Update Artikel</button>
</form>
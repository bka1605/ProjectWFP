<h5 class="mb-3">Update Artikel (Type B)</h5>

<div class="mb-3">
    <label for="cjudul" class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="cjudul" value="{{ $data->judul }}">
</div>
<div class="mb-3">
    <label for="ckategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="ckategori" value="{{ $data->kategori }}">
</div>
<div class="mb-3">
    <label for="ctanggal" class="form-label fw-semibold">Tanggal Publish <span class="text-danger">*</span></label>
    <input type="date" class="form-control" id="ctanggal" value="{{ $data->tanggal_publish }}">
</div>
<div class="mb-3">
    <label for="ckonten" class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
    <textarea class="form-control" id="ckonten" rows="4">{{ $data->konten }}</textarea>
    <small class="form-text text-muted">Ubah data, lalu klik Simpan Perubahan.</small>
</div>

<button type="button" class="btn btn-warning w-100" onclick="saveDataUpdate({{ $data->id }})">
    Simpan Perubahan
</button>
{{--
    categories/getEditFormB.blade.php
    Digunakan untuk Edit Type B: update data via Ajax TANPA reload halaman.
    Tidak pakai <form> tag - submit ditangani oleh fungsi saveDataUpdate() di JS.
--}}

<h5 class="mb-3">Update Category</h5>

<div class="mb-3">
    <label for="cname" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
    <input type="text"
           class="form-control"
           id="cname"
           name="namecate"
           value="{{ $data->category_name }}"
           placeholder="Nama kategori">
    <small class="form-text text-muted">Ubah nama category, lalu klik Simpan.</small>
</div>

<button type="button"
        class="btn btn-warning w-100"
        onclick="saveDataUpdate({{ $data->id }})">
    Simpan Perubahan
</button>
<form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="{{ $doctor->nama }}" required>
    </div>
    <div class="mb-3">
        <label>Spesialisasi</label>
        <input type="text" name="spesialisasi" class="form-control" value="{{ $doctor->spesialisasi }}" required>
    </div>
    <div class="mb-3">
        <label>Nomor Telepon</label>
        <input type="text" name="nomor_telepon" class="form-control" value="{{ $doctor->nomor_telepon }}" required>
    </div>
    <div class="mb-3">
        <label>Lama Kerja</label>
        <input type="number" name="lama_kerja" class="form-control" value="{{ $doctor->lama_kerja }}" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
</form>
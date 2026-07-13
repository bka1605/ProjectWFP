@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">{{ $judul }}</h2>
                    <p class="text-muted mb-0">Daftar artikel kesehatan di platform VitaGuard.</p>
                </div>
                
            </div>

            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalCreateArticle">
                <i class="bi bi-plus-lg"></i> + New Article
            </button>
        </div>
    </div>

    <div id="ajax-alert"></div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Judul Artikel</th>
                        <th>Kategori</th>
                        <th>Tanggal Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr id="tr_{{ $article->id }}">
                            <td>{{ $article->id }}</td>
                            <td id="td_judul_{{ $article->id }}">{{ $article->judul }}</td>
                            <td id="td_kategori_{{ $article->id }}">{{ $article->kategori }}</td>
                            <td id="td_tanggal_{{ $article->id }}">{{ $article->tanggal_publish }}</td>
                            <td>
                                <a href="#modalEditB" class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                    onclick="getEditFormB({{ $article->id }})">Edit</a>

                                @can('delete-permission', Auth::user())
                                    <form method="POST" action="{{ route('articles.destroy', $article->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah yakin untuk menghapus artikel?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modalCreateArticle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('articles.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="kategori" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Publish <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_publish" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="konten" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditA" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Artikel (Type A)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentA">
                    <div class="text-center text-muted">Memuat form...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditB" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Artikel (Type B)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentB">
                    <div class="text-center text-muted">Memuat form...</div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function getEditForm(id) {
            $('#modalContentA').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("article.getEditForm") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentA').html(data.msg); },
                error: function () { $('#modalContentA').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function getEditFormB(id) {
            $('#modalContentB').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("article.getEditFormB") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentB').html(data.msg); },
                error: function () { $('#modalContentB').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function saveDataUpdate(id) {
            var judul = $('#cjudul').val();
            var kategori = $('#ckategori').val();
            var konten = $('#ckonten').val();
            var tanggal = $('#ctanggal').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("article.saveDataUpdate") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'judul': judul,
                    'kategori': kategori,
                    'konten': konten,
                    'tanggal_publish': tanggal
                },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#td_judul_' + id).html(judul);
                        $('#td_kategori_' + id).html(kategori);
                        $('#td_tanggal_' + id).html(tanggal);

                        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditB'));
                        modal.hide();

                        $('#ajax-alert').html('<div class="alert alert-success alert-dismissible fade show">Artikel berhasil diupdate! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                },
                error: function () { alert('Gagal menyimpan data.'); }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("article.deleteData") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#tr_' + id).fadeOut(400, function () { $(this).remove(); });
                        $('#ajax-alert').html('<div class="alert alert-success alert-dismissible fade show">Artikel berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                },
                error: function () { alert('Gagal menghapus data.'); }
            });
        }
    </script>
@endpush
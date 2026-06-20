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
            @if (session('status'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">+ New Category</a>
            <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
                + New Category (Modal)
            </button>

            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">
                Klik <a href="#" onclick="showInfo(); return false;">informasi category</a>
                untuk melihat category dengan jumlah service terbanyak.
            </p>
        </div>

        <a href="{{ route('category.showExpensiveService') }}" class="btn btn-outline-primary">
            Report Service Termahal
        </a>
    </div>

    <div id="showinfo"></div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Image</th>
                        <th>Total Services</th>
                        <th>List Services</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr id="tr_{{ $category->id }}">
                            <td>{{ $category->id }}</td>

                            <td id="td_name_{{ $category->id }}">{{ $category->category_name }}</td>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#imageModal-{{ $category->id }}">
                                    Show Image
                                </button>
                            </td>

                            <td>{{ $category->services_count }}</td>

                            <td>
                                <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" onclick="showDetail({{ $category->id }})">
                                    Details
                                </button>
                            </td>

                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>

                                <a href="#modalEditA" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                   onclick="getEditForm({{ $category->id }})">Edit (Modal A)</a>

                                <a href="#modalEditB" class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                   onclick="getEditFormB({{ $category->id }})">Edit (Modal B)</a>

                                @can('delete-permission', Auth::user())
                                    <a href="#" class="btn btn-danger btn-sm"
                                       onclick="if(confirm('Yakin hapus category \'{{ $category->category_name }}\'?')) deleteDataRemove({{ $category->id }})">
                                        Delete (Ajax)
                                    </a>

                                    <form method="POST" action="{{ route('categories.destroy', $category->id) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin hapus category {{ $category->category_name }}?')">
                                    </form>
                                @endcan
                                </td>
                        </tr>

                        @push('modals')
                            <div class="modal fade" id="imageModal-{{ $category->id }}" tabindex="-1"
                                aria-labelledby="imageModalLabel-{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="imageModalLabel-{{ $category->id }}">
                                                Gambar untuk {{ $category->category_name }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid rounded"
                                                    alt="{{ $category->category_name }}">
                                            @else
                                                <div class="alert alert-warning mb-0">
                                                    Gambar belum tersedia untuk category ini.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endpush
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data category.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detail-title">List of Services</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail-body">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    <div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Category Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal_category_name" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal_category_name"
                                   name="category_name" placeholder="Nama kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal_image" class="form-label fw-semibold">Gambar (opsional)</label>
                            <input type="file" class="form-control" id="modal_image" name="image" accept="image/*">
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
@endpush

@push('modals')
    <div class="modal fade" id="modalEditA" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category (Type A)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentA">
                    <div class="text-center text-muted">Memuat form...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    <div class="modal fade" id="modalEditB" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category (Type B)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContentB">
                    <div class="text-center text-muted">Memuat form...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function showInfo() {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showInfo") }}',
                data: { '_token': '{{ csrf_token() }}' },
                success: function (data) {
                    $('#showinfo').html(data.msg);
                },
                error: function () {
                    $('#showinfo').html('<div class="alert alert-danger">Gagal mengambil informasi category.</div>');
                }
            });
        }

        function showDetail(id) {
            $('#detail-title').html('Loading...');
            $('#detail-body').html('Loading...');
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showListServices") }}',
                data: { '_token': '{{ csrf_token() }}', 'idcat': id },
                success: function (data) {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                },
                error: function () {
                    $('#detail-title').html('Error');
                    $('#detail-body').html('<div class="alert alert-danger">Gagal mengambil list services.</div>');
                }
            });
        }

        function getEditForm(id) {
            $('#modalContentA').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("category.getEditForm") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function (data) {
                    $('#modalContentA').html(data.msg);
                },
                error: function () {
                    $('#modalContentA').html('<div class="alert alert-danger">Gagal memuat form.</div>');
                }
            });
        }

        function getEditFormB(id) {
            $('#modalContentB').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("category.getEditFormB") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function (data) {
                    $('#modalContentB').html(data.msg);
                },
                error: function () {
                    $('#modalContentB').html('<div class="alert alert-danger">Gagal memuat form.</div>');
                }
            });
        }

        function saveDataUpdate(id) {
            var name = $('#cname').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("category.saveDataUpdate") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'name': name
                },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#td_name_' + id).html(name);
                        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditB'));
                        modal.hide();
                        var alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">Category berhasil diupdate! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                        $('#showinfo').html(alert);
                    }
                },
                error: function () {
                    alert('Gagal menyimpan data. Silakan coba lagi.');
                }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.deleteData") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#tr_' + id).fadeOut(400, function () {
                            $(this).remove();
                        });
                        var alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">Category berhasil dihapus! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                        $('#showinfo').html(alert);
                    }
                },
                error: function () {
                    alert('Gagal menghapus data. Silakan coba lagi.');
                }
            });
        }
    </script>
@endpush
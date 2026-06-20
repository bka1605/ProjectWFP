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
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreateService">
                + New Service (Modal)
            </button>

            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar layanan kesehatan yang tersedia di VitaGuard.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
            Lihat Categories
        </a>
    </div>

    <div id="ajax-alert"></div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Availability</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr id="tr_{{ $service->id }}">
                            <td>{{ $service->id }}</td>
                            <td id="td_name_{{ $service->id }}" class="fw-semibold">{{ $service->service_name }}</td>
                            <td id="td_desc_{{ $service->id }}">{{ $service->description }}</td>
                            <td id="td_avail_{{ $service->id }}">{{ $service->availability }}</td>
                            <td id="td_price_{{ $service->id }}">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td id="td_cat_{{ $service->id }}">{{ $service->category->category_name ?? '-' }}</td>
                            <td>
                                <a href="#modalEditA" class="btn btn-secondary btn-sm mb-1" data-bs-toggle="modal"
                                    onclick="getEditForm({{ $service->id }})">Edit (Type A)</a>

                                <a href="#modalEditB" class="btn btn-info btn-sm text-white mb-1" data-bs-toggle="modal"
                                    onclick="getEditFormB({{ $service->id }})">Edit (Type B)</a>

                                @can('delete-permission', Auth::user())
                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                        onclick="if(confirm('Yakin hapus service ini?')) deleteDataRemove({{ $service->id }})">
                                        Delete (Ajax)
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modalCreateService" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Service Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('services.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="service_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Availability <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="availability" placeholder="Misal: 08:00 - 17:00"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Price (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="price" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="" disabled selected>-- Pilih Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
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
                    <h5 class="modal-title">Edit Service (Type A)</h5>
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
                    <h5 class="modal-title">Edit Service (Type B)</h5>
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
                url: '{{ route("service.getEditForm") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentA').html(data.msg); },
                error: function () { $('#modalContentA').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function getEditFormB(id) {
            $('#modalContentB').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("service.getEditFormB") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentB').html(data.msg); },
                error: function () { $('#modalContentB').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function saveDataUpdate(id) {
            var service_name = $('#cservice_name').val();
            var description = $('#cdescription').val();
            var availability = $('#cavailability').val();
            var price = $('#cprice').val();
            var category_id = $('#ccategory_id').val();
            var category_name = $('#ccategory_id option:selected').text();

            $.ajax({
                type: 'POST',
                url: '{{ route("service.saveDataUpdate") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'service_name': service_name,
                    'description': description,
                    'availability': availability,
                    'price': price,
                    'category_id': category_id
                },
                success: function (data) {
                    if (data.status === 'oke') {
                        var formattedPrice = new Intl.NumberFormat('id-ID').format(price);

                        $('#td_name_' + id).html(service_name);
                        $('#td_desc_' + id).html(description);
                        $('#td_avail_' + id).html(availability);
                        $('#td_price_' + id).html('Rp ' + formattedPrice);
                        $('#td_cat_' + id).html(category_name);

                        var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditB'));
                        modal.hide();

                        $('#ajax-alert').html('<div class="alert alert-success alert-dismissible fade show">' + data.msg + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                },
                error: function () { alert('Gagal menyimpan data.'); }
            });
        }

        function deleteDataRemove(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("service.deleteData") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#tr_' + id).fadeOut(400, function () { $(this).remove(); });
                        $('#ajax-alert').html('<div class="alert alert-success alert-dismissible fade show">' + data.msg + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    } else if (data.status === 'error') {
                        $('#ajax-alert').html('<div class="alert alert-danger alert-dismissible fade show">' + data.msg + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                },
                error: function (xhr) {
                    $('#ajax-alert').html('<div class="alert alert-danger alert-dismissible fade show">Data gagal dihapus. Pastikan tidak ada transaksi yang terkait dengan service ini.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                }
            });
        }
    </script>
@endpush
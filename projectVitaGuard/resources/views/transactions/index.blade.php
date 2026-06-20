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

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#modalCreateTransaction">
                + New Transaction (Modal)
            </button>

            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar transaksi layanan kesehatan VitaGuard.</p>
        </div>
    </div>

    <div id="ajax-alert"></div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Services</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr id="tr_{{ $transaction->id }}">
                            <td>{{ $transaction->id }}</td>
                            <td id="td_user_{{ $transaction->id }}">{{ $transaction->user->name ?? '-' }}</td>
                            <td id="td_services_{{ $transaction->id }}">
                                @forelse ($transaction->services as $service)
                                    <span class="badge bg-primary mb-1 me-1">{{ $service->service_name }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td id="td_tanggal_{{ $transaction->id }}">{{ $transaction->tanggal_transaksi }}</td>
                            <td id="td_status_{{ $transaction->id }}">
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="#modalEditA" class="btn btn-secondary btn-sm mb-1" data-bs-toggle="modal"
                                    onclick="getEditForm({{ $transaction->id }})">Edit (Type A)</a>

                                <a href="#modalEditB" class="btn btn-info btn-sm text-white mb-1" data-bs-toggle="modal"
                                    onclick="getEditFormB({{ $transaction->id }})">Edit (Type B)</a>

                                @can('delete-permission', Auth::user())
                                    <button type="button" class="btn btn-danger btn-sm mb-1"
                                        onclick="if(confirm('Yakin hapus transaksi #{{ $transaction->id }}?')) deleteDataRemove({{ $transaction->id }})">
                                        Delete (Ajax)
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modalCreateTransaction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Member / Pasien <span class="text-danger">*</span></label>
                            <select class="form-select" name="user_id" required>
                                <option value="" disabled selected>-- Pilih Member --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Services <span class="text-danger">*</span></label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($services as $service)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" name="service_ids[]"
                                            value="{{ $service->id }}" id="create_service_{{ $service->id }}">
                                        <label class="form-check-label" for="create_service_{{ $service->id }}">
                                            {{ $service->service_name }} <span class="text-muted">— Rp
                                                {{ number_format($service->price, 0, ',', '.') }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transaksi <span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="tanggal_transaksi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditA" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi (Type A)</h5>
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
                    <h5 class="modal-title">Edit Transaksi (Type B)</h5>
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
                url: '{{ route("transaction.getEditForm") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentA').html(data.msg); },
                error: function () { $('#modalContentA').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function getEditFormB(id) {
            $('#modalContentB').html('<div class="text-center text-muted">Memuat form...</div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("transaction.getEditFormB") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) { $('#modalContentB').html(data.msg); },
                error: function () { $('#modalContentB').html('<div class="alert alert-danger">Gagal memuat form.</div>'); }
            });
        }

        function saveDataUpdate(id) {
            var user_id = $('#cuser_id').val();
            var tanggal = $('#ctanggal_transaksi').val();
            var status = $('#cstatus').val();

            var service_ids = [];
            $('.cservice_checkbox:checked').each(function () {
                service_ids.push($(this).val());
            });

            if (service_ids.length === 0) {
                alert("Pilih minimal satu service!");
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("transaction.saveDataUpdate") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'user_id': user_id,
                    'tanggal_transaksi': tanggal,
                    'status': status,
                    'service_ids': service_ids
                },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#td_user_' + id).html(data.user_name);
                        $('#td_services_' + id).html(data.services_html);
                        $('#td_tanggal_' + id).html(data.tanggal);
                        $('#td_status_' + id).html(data.status_html);

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
                url: '{{ route("transaction.deleteData") }}',
                data: { '_token': '<?php echo csrf_token(); ?>', 'id': id },
                success: function (data) {
                    if (data.status === 'oke') {
                        $('#tr_' + id).fadeOut(400, function () { $(this).remove(); });
                        $('#ajax-alert').html('<div class="alert alert-success alert-dismissible fade show">' + data.msg + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    }
                },
                error: function () { alert('Gagal menghapus data.'); }
            });
        }
    </script>
@endpush
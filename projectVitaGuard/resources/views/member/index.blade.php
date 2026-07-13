@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $judul }}</h2>
            <p class="text-muted mb-0">Daftar pasien/member yang terdaftar pada VitaGuard.</p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
            + Tambah Member
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nama Member</th>
                        <th>Email</th>
                        <th>Email Verified</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                @if ($member->email_verified_at)
                                    <span class="badge bg-success">Sudah</span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td>{{ $member->created_at }}</td>
                            <td>
                                <button class="btn btn-sm btn-info"
                                    onclick="editUser('{{ $member->id }}', '{{ $member->name }}', '{{ $member->email }}', 'member')">Edit</button>

                                <form action="{{ route('account.destroy', $member->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus member ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data member.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<div class="modal fade" id="modalCreateUser" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('account.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control"
                        required></div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-select" value="member" disabled>
                        <option value="member">Member</option>
                        <option value="dokter">Dokter</option>
                        <option value="admin">Admin</option>
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

<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label>Nama</label><input type="text" name="name" id="edit_name" class="form-control"
                        required></div>
                <div class="mb-3"><label>Email</label><input type="email" name="email" id="edit_email"
                        class="form-control" required></div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" id="edit_role" class="form-select" value="member" disabled>
                        <option value="member">Member</option>
                        <option value="dokter">Dokter</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-warning">Update Perubahan</button></div>
        </form>
    </div>
</div>

<script>
    function editUser(id, name, email, role) {
        // Isi value ke input modal
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;

        // Ubah action form supaya mengarah ke route update yang benar
        document.getElementById('editForm').action = '/account/' + id;

        // Tampilkan modal (menggunakan Bootstrap 5)
        var myModal = new bootstrap.Modal(document.getElementById('modalEditUser'));
        myModal.show();
    }
</script>
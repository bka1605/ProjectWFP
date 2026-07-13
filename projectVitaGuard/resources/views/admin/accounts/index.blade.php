@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="fw-bold">Manajemen Akun</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                + Tambah User
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins->concat($doctors)->concat($members) as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info"
                                        onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                        Edit
                                    </a>

                                    <form action="{{ route('account.destroy', $user->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus user ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal create --}}

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
                        <select name="role" class="form-select">
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

    {{-- modal edit --}}

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
                        <select name="role" id="edit_role" class="form-select">
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
@endsection
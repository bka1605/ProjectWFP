@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>

                            <td>
                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal-{{ $category->id }}">
                                    Show Image
                                </button>
                            </td>

                            <td>{{ $category->services_count }}</td>

                            <td>
                                <button type="button"
                                        class="btn btn-info btn-sm text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        onclick="showDetail({{ $category->id }})">
                                    Details
                                </button>
                            </td>
                        </tr>

                        @push('modals')
                            <div class="modal fade" id="imageModal-{{ $category->id }}" tabindex="-1" aria-labelledby="imageModalLabel-{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="imageModalLabel-{{ $category->id }}">
                                                Gambar untuk {{ $category->category_name }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body text-center">
                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                     class="img-fluid rounded"
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
                            <td colspan="5" class="text-center text-muted">Belum ada data category.</td>
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

                <div class="modal-body" id="detail-body">
                    Loading...
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

@push('script')
    <script>
        function showInfo() {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showInfo") }}',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#showinfo').html(data.msg);
                },
                error: function() {
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
                data: {
                    '_token': '{{ csrf_token() }}',
                    'idcat': id
                },
                success: function(data) {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                },
                error: function() {
                    $('#detail-title').html('Error');
                    $('#detail-body').html('<div class="alert alert-danger">Gagal mengambil list services.</div>');
                }
            });
        }
    </script>
@endpush
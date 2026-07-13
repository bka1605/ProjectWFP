@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-1">📰 Edukasi & Artikel Kesehatan</h3>
            <p class="text-muted mb-0">Baca informasi dan tips kesehatan terpercaya dari para ahli kami.</p>
        </div>
        
        <div class="col-md-6 mt-3 mt-md-0">
            <form action="{{ route('member.articles') }}" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white border">
                <input type="text" name="search" class="form-control border-0 px-4 py-2" placeholder="Cari artikel berdasarkan judul..." value="{{ $search }}">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            @if(!empty($search))
                <div class="text-muted small mt-2 ps-3">
                    Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong> 
                    <a href="{{ route('member.articles') }}" class="text-danger ms-2 text-decoration-underline">Hapus Pencarian</a>
                </div>
            @endif
        </div>
    </div>

    <hr class="mb-5">

    <div class="row g-4">
        @forelse($articles as $artikel)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 180px; font-size: 4rem;">
                            <i class="bi bi-journal-medical"></i>
                        </div>
                                                
                        <div class="p-4">
                            <h5 class="fw-bold text-dark mb-1 line-clamp" style="font-weight: 700 !important;">{{ $artikel->judul }}</h5>
                            
                            <div class="text-muted small mb-3" style="font-size: 0.85rem;">
                                <i class="bi bi-calendar3 text-primary me-1"></i> {{ $artikel->created_at ? $artikel->created_at->format('d M Y') : '05 Jul 2026' }}
                            </div>
                            
                            <p class="text-muted small mb-0" style="text-align: justify;">
                                {{ Str::limit(strip_tags($artikel->konten ?? 'Klik detail untuk membaca isi materi edukasi kesehatan ini selengkapnya...'), 100) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('member.articles.detail', $artikel->id) }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center py-5">
                <div class="text-muted fs-1 mb-3"><i class="bi bi-journal-x"></i></div>
                <h5 class="fw-bold text-secondary">Artikel Tidak Ditemukan</h5>
                <p class="text-muted">Maaf, kata kunci "{{ $search }}" tidak cocok dengan judul artikel mana pun.</p>
                <a href="{{ route('member.articles') }}" class="btn btn-primary btn-sm rounded-pill px-4 mt-2">Lihat Semua Artikel</a>
            </div>
        @endforelse
    </div>
</div>

<style>
    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection
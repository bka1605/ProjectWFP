@extends('layouts.medilab')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('member.articles') }}" class="btn btn-light btn-sm text-muted rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Artikel
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="card border-0 shadow-sm rounded-3 overflow-hidden p-4 p-md-5 bg-white">
                
                <h1 class="fw-bold text-dark mb-3">{{ $article->judul }}</h1>
                
                <div class="d-flex align-items-center text-muted small gap-3 border-bottom pb-3 mb-4">
                    <span><i class="bi bi-calendar3 text-primary"></i> {{ $article->created_at ? $article->created_at->format('d M Y') : '05 Jul 2026' }}</span>
                    <span><i class="bi bi-tags-fill text-primary"></i> Kategori: {{ $article->kategori }}</span>
                    <span><i class="bi bg-success text-white px-2 py-1 rounded small fs-6 bi-shield-check"></i> Terverifikasi</span>
                </div>

                <div class="bg-light text-primary d-flex align-items-center justify-content-center rounded-3 mb-4 shadow-inner" style="height: 350px; font-size: 6rem;">
                    <i class="bi bi-file-earmark-medical"></i>
                </div>

                <div class="article-content text-secondary lh-lg fs-5">
                    {!! nl2br(e($article->konten ?? 'Konten artikel kosong.')) !!}
                </div>

                <hr class="my-5">

                <div class="p-3 bg-light rounded border-start border-warning border-4 small text-muted">
                    <strong>Pernyataan Penting:</strong> Seluruh materi edukasi di platform VitaGuard ditujukan sebagai informasi pelengkap, bukan pengganti diagnosis atau resep medis langsung dari dokter Anda.
                </div>

            </article>
        </div>
    </div>
</div>

<style>
    .article-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
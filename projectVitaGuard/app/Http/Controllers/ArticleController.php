<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('tanggal_publish', 'desc')->get();

        return view('articles.index', [
            'judul' => 'Daftar Artikel Kesehatan',
            'articles' => $articles,
        ]);
    }
}
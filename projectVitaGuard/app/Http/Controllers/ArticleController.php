<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->get();
        return view('articles.index', [
            'judul' => 'Daftar Artikel Kesehatan',
            'articles' => $articles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        Article::create($request->all());

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        $article->update($request->all());

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete-permission', Auth::user());
        $article->delete();
        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }

    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);

        if (!$data)
            return response()->json(['status' => 'not_found', 'msg' => '<div class="alert alert-danger">Data tidak ditemukan.</div>'], 404);

        return response()->json([
            'status' => 'oke',
            'msg' => view('articles.getEditForm', compact('data'))->render(),
        ], 200);
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);

        if (!$data)
            return response()->json(['status' => 'not_found', 'msg' => '<div class="alert alert-danger">Data tidak ditemukan.</div>'], 404);

        return response()->json([
            'status' => 'oke',
            'msg' => view('articles.getEditFormB', compact('data'))->render(),
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);

        if (!$data)
            return response()->json(['status' => 'not_found', 'msg' => 'Data tidak ditemukan.'], 404);

        $data->judul = $request->judul;
        $data->kategori = $request->kategori;
        $data->konten = $request->konten;
        $data->tanggal_publish = $request->tanggal_publish;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Artikel berhasil diupdate!',
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);

        if (!$data)
            return response()->json(['status' => 'not_found', 'msg' => 'Data tidak ditemukan.'], 404);

        $data->delete();
        return response()->json([
            'status' => 'oke',
            'msg' => 'Artikel berhasil dihapus!',
        ], 200);
    }
}
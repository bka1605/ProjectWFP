<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('services')->get();

        return view('categories.index', [
            'judul' => 'Portal Manajemen: Daftar Kategori Layanan',
            'categories' => $categories,
        ]);
    }
}
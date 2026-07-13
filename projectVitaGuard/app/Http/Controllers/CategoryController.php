<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('services')
            ->withCount('services')
            ->orderBy('category_name', 'asc')
            ->get();

        return view('categories.index', [
            'judul' => 'List of Categories',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('categories.create', [
            'judul' => 'Tambah Category Baru',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $data = new Category();
        $data->category_name = $request->get('category_name');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category', 'public');
            $data->image = $path;
        }

        $data->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', [
            'judul' => 'Edit Category',
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category->category_name = $request->get('category_name');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category', 'public');
            $category->image = $path;
        }

        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete-permission', Auth::user());
        try {
            $category->delete(); // ini soft delete
            return redirect()->route('categories.index')
                ->with('success', 'Category berhasil dihapus!');
        } catch (\PDOException $ex) {
            $msg = 'Tidak dapat menghapus category ini karena masih memiliki data terkait.';
            return redirect()->route('categories.index')
                ->with('status', $msg);
        }
    }

    public function showExpensiveService()
    {
        $categories = Category::with(['services' => function ($query) {
            $query->orderByDesc('price');
        }])->orderBy('category_name', 'asc')->get();

        return view('categories.expensiveservice', [
            'judul' => 'Most Expensive Service in Each Category',
            'categories' => $categories,
        ]);
    }

    public function showInfo()
    {
        $highestServiceCategory = Category::withCount('services')
            ->orderByDesc('services_count')
            ->first();

        if (!$highestServiceCategory) {
            return response()->json([
                'status' => 'empty',
                'msg' => '<div class="alert alert-warning">Belum ada data category.</div>',
            ], 200);
        }

        return response()->json([
            'status' => 'oke',
            'msg' => '<div class="alert alert-success">Category dengan jumlah service terbanyak adalah: <b>' .
                $highestServiceCategory->category_name .
                '</b> dengan total <b>' .
                $highestServiceCategory->services_count .
                '</b> service.</div>',
        ], 200);
    }

    public function showListServices()
    {
        $category = Category::with('services')->find(request('idcat'));

        if (!$category) {
            return response()->json([
                'status' => 'not_found',
                'title' => 'Category tidak ditemukan',
                'body' => '<div class="alert alert-danger">Data category tidak ditemukan.</div>',
            ], 404);
        }

        $data = $category->services;
        $name = $category->category_name;

        return response()->json([
            'status' => 'oke',
            'title' => $name . ' - Service List',
            'body' => view('categories.showListServices', compact('name', 'data'))->render(),
        ], 200);
    }

    public function getEditForm(Request $request)
    {
        $id   = $request->id;
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'not_found',
                'msg'    => '<div class="alert alert-danger">Category tidak ditemukan.</div>',
            ], 404);
        }

        return response()->json([
            'status' => 'oke',
            'msg'    => view('categories.getEditForm', compact('data'))->render(),
        ], 200);
    }

    public function getEditFormB(Request $request)
    {
        $id   = $request->id;
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'not_found',
                'msg'    => '<div class="alert alert-danger">Category tidak ditemukan.</div>',
            ], 404);
        }

        return response()->json([
            'status' => 'oke',
            'msg'    => view('categories.getEditFormB', compact('data'))->render(),
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id   = $request->id;
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'not_found',
                'msg'    => 'Category tidak ditemukan.',
            ], 404);
        }

        $data->category_name = $request->name;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg'    => 'Category berhasil diupdate!',
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $this->authorize('delete-permission', Auth::user());
        $id   = $request->id;
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'not_found',
                'msg'    => 'Category tidak ditemukan.',
            ], 404);
        }

        try {
            $data->delete(); // soft delete
            return response()->json([
                'status' => 'oke',
                'msg'    => 'Category berhasil dihapus!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Tidak dapat menghapus category ini.',
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;

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
}
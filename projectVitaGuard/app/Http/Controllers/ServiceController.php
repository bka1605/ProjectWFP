<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->get();

        return view('services.index', [
            'judul' => 'Daftar Layanan Kesehatan',
            'services' => $services,
        ]);
    }
}
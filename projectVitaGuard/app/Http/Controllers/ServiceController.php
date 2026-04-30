<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')
            ->orderBy('service_name', 'asc')
            ->get();

        return view('services.index', [
            'judul' => 'List of Services',
            'services' => $services,
        ]);
    }

    public function show(string $id)
    {
        $service = Service::with('category')->findOrFail($id);

        return view('services.show', [
            'judul' => 'Service Detail',
            'service' => $service,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

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

    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('services.create', [
            'judul' => 'Tambah Service Baru',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'availability' => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
        ]);

        $data = new Service();
        $data->service_name = $request->get('service_name');
        $data->description  = $request->get('description');
        $data->availability = $request->get('availability');
        $data->price        = $request->get('price');
        $data->category_id  = $request->get('category_id');
        $data->save();

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('services.edit', [
            'judul'      => 'Edit Service',
            'service'    => $service,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'availability' => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
        ]);

        $service->service_name = $request->get('service_name');
        $service->description  = $request->get('description');
        $service->availability = $request->get('availability');
        $service->price        = $request->get('price');
        $service->category_id  = $request->get('category_id');
        $service->save();

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil diupdate!');
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete(); // soft delete
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil dihapus!');
        } catch (\PDOException $ex) {
            return redirect()->route('services.index')
                ->with('status', 'Tidak dapat menghapus service ini karena masih memiliki data terkait.');
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->orderBy('id', 'desc')->get();
        $categories = Category::orderBy('category_name', 'asc')->get(); 

        return view('services.index', [
            'judul' => 'List of Services',
            'services' => $services,
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

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service berhasil ditambahkan!');
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

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service berhasil diupdate!');
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete-permission', Auth::user());
        try {
            $service->delete();
            return redirect()->route('services.index')->with('success', 'Service berhasil dihapus!');
        } catch (\PDOException $ex) {
            return redirect()->route('services.index')->with('status', 'Tidak dapat menghapus service karena masih memiliki data terkait.');
        }
    }

    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);
        $categories = Category::orderBy('category_name', 'asc')->get();

        if (!$data) return response()->json(['status' => 'not_found', 'msg' => '<div class="alert alert-danger">Data tidak ditemukan.</div>'], 404);

        return response()->json([
            'status' => 'oke',
            'msg'    => view('services.getEditForm', compact('data', 'categories'))->render(),
        ], 200);
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);
        $categories = Category::orderBy('category_name', 'asc')->get();

        if (!$data) return response()->json(['status' => 'not_found', 'msg' => '<div class="alert alert-danger">Data tidak ditemukan.</div>'], 404);

        return response()->json([
            'status' => 'oke',
            'msg'    => view('services.getEditFormB', compact('data', 'categories'))->render(),
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);

        if (!$data) return response()->json(['status' => 'not_found', 'msg' => 'Data tidak ditemukan.'], 404);

        $data->service_name = $request->service_name;
        $data->description  = $request->description;
        $data->availability = $request->availability;
        $data->price        = $request->price;
        $data->category_id  = $request->category_id;
        $data->save();

        return response()->json([
            'status' => 'oke',
            'msg'    => 'Service berhasil diupdate!',
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Service::find($id);

        if (!$data) return response()->json(['status' => 'not_found', 'msg' => 'Data tidak ditemukan.'], 404);

        try {
            $data->delete();
            return response()->json(['status' => 'oke', 'msg' => 'Service berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus karena ada data terkait (Transaction).'], 500);
        }
    }
}
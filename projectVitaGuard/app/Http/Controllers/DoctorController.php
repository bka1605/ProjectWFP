<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();

        return view('doctors.index', [
            'judul' => 'Daftar Dokter',
            'doctors' => $doctors,
        ]);
    }
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus!');
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'nama' => 'required',
            'spesialisasi' => 'required',
            'nomor_telepon' => 'required',
            'lama_kerja' => 'required|numeric',
        ]);

        $doctor->update($request->all());
        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diupdate!');
    }

    public function getEditForm(Request $request)
    {
        $doctor = Doctor::findOrFail($request->id);
        $html = view('doctors.getEditForm', compact('doctor'))->render();
        return response()->json(['msg' => $html]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'spesialisasi' => 'required',
            'nomor_telepon' => 'required',
            'lama_kerja' => 'required|numeric',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan!');
    }
}
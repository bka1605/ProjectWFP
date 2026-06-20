<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
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
    public function destroy() 
    {
        $this->authorize('delete-permission', Auth::user());
    }
}
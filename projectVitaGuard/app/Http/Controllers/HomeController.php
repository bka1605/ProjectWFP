<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $stats = [
            'total_dokter' => \App\Models\Doctor::count(),
            'total_member' => \App\Models\User::where('role', 'member')->count(),
            'total_artikel' => \App\Models\Article::count(),
            'total_booking' => 0,
            'konsultasi_berlangsung' => 0,
            'konsultasi_selesai' => 0,
        ];

        return view('admin.dashboard', [
            'judul' => 'Dashboard Admin VitaGuard',
            'stats' => $stats,
        ]);
    }

    public function dashboardDokter()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $dokter = \App\Models\Doctor::where('nama', $user->name)->first();

        // Menggunakan collect() kosong sebagai bawaan aman jika tabel transaksi error
        $konsultasiAktif = collect();
        $riwayatKonsultasi = collect();
        
        if ($dokter) {
            // Blok Try-Catch: Mencegah halaman Anda merah/error jika kolom tabel kelompok berbeda
            try {
                $konsultasiAktif = \App\Models\Transaction::where('doctor_id', $dokter->id)
                    ->whereIn('status', ['active', 'pending', 'berlangsung'])
                    ->with('user')
                    ->get();

                $riwayatKonsultasi = \App\Models\Transaction::where('doctor_id', $dokter->id)
                    ->whereIn('status', ['completed', 'selesai', 'success']) 
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } catch (\Exception $e) {
                // Jika tabel transaksi error, bypass dan biarkan data kosong agar halaman Anda tetap tampil rapi
                $konsultasiAktif = collect();
                $riwayatKonsultasi = collect();
            }
        }

        return view('doctors.index', [
            'judul'             => 'Dashboard Dokter VitaGuard',
            'dokter'            => $dokter,
            'konsultasiAktif'   => $konsultasiAktif,
            'riwayatKonsultasi' => $riwayatKonsultasi,
            'doctors'           => collect()
        ]);
    }

    public function updateProfileDokter(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'lama_kerja' => 'required|numeric',
        ]);

        // Cari berdasarkan nama lama user saat ini
        \App\Models\Doctor::updateOrCreate(
            ['nama' => $user->name], 
            [
                'nama' => $request->nama,
                'spesialisasi' => $request->spesialisasi,
                'nomor_telepon' => $request->nomor_telepon,
                'lama_kerja' => $request->lama_kerja,
            ]
        );

        // Sinkronisasikan nama baru ke tabel users agar login tidak terputus
        $user->update(['name' => $request->nama]);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
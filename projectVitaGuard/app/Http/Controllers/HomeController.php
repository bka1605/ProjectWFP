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
        /** @var \App\Models\User $user */
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

    public function dashboardMember()
    {
        
        if (view()->exists('member.dashboard')) {
            return view('member.dashboard', ['judul' => 'Dashboard Member VitaGuard']);
        }
        
        return view('home');
    }

    // Mengambil semua data dari tabel doctors untuk menampilkan semua doctors

    public function memberDoctors()
    {
        
        $allDoctors = \App\Models\Doctor::all();

        return view('member.listdoctors', [
            'judul'   => 'Daftar Dokter Spesialis - VitaGuard',
            'doctors' => $allDoctors
        ]);
    }

    // Untuk menampilkan profile dokter tertentu 
    public function memberDoctorProfile($id)
    {
        $dokter = \App\Models\Doctor::findOrFail($id);

        return view('member.doctor_profile', [
            'judul'  => 'Profil ' . $dokter->nama . ' - VitaGuard',
            'dokter' => $dokter
        ]);
    }

    public function memberArticles(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');

        $query = \App\Models\Article::query();

        if (!empty($search)) {
            $query->where('judul', 'LIKE', '%' . $search . '%');
        }

        $allArticles = $query->orderBy('created_at', 'desc')->get();

        return view('member.listarticles', [
            'judul' => 'Artikel Kesehatan - VitaGuard',
            'articles' => $allArticles,
            'search' => $search 
        ]);
    }

   public function memberArticleDetail($id)
    {
        // Cari artikel berdasarkan ID
        $artikel = \App\Models\Article::findOrFail($id);

        return view('member.detailarticle', [
            'judul' => $artikel->judul . ' - VitaGuard', // Menggunakan $artikel->judul
            'article' => $artikel
        ]);
    }
    
    public function memberHistory()
    {
        
        $user = \Illuminate\Support\Facades\Auth::user();

        $riwayat = collect();

        try {
            
            $riwayat = \App\Models\Transaction::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            
            $riwayat = collect();
        }

        return view('member.history', [
            'judul' => 'Riwayat Konsultasi Saya - VitaGuard',
            'history' => $riwayat
        ]);
    }
}
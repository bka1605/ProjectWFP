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
            // 3 ini hrs e nanti diisi sama Orang 4 & 5
            'total_booking' => 0,
            'konsultasi_berlangsung' => 0,
            'konsultasi_selesai' => 0,
        ];

        return view('admin.dashboard', [
            'judul' => 'Dashboard Admin VitaGuard',
            'stats' => $stats,
        ]);
    }
}

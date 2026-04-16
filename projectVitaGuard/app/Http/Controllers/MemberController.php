<?php

namespace App\Http\Controllers;

use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::all();

        return view('members.index', [
            'judul' => 'Portal Manajemen: Daftar Pasien / Member',
            'members' => $members,
        ]);
    }
}
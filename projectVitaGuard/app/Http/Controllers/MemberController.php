<?php

namespace App\Http\Controllers;

use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = \App\Models\User::where('role', 'member')->get();

        return view('member.index', [
            'judul' => 'Daftar Member',
            'members' => $members,
        ]);
    }
}
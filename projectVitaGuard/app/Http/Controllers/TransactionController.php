<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('tanggal_transaksi', 'desc')->get();

        return view('transactions.index', [
            'judul' => 'Portal Manajemen: Daftar Transaksi',
            'transactions' => $transactions,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'services'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('transactions.index', [
            'judul' => 'Portal Manajemen: Daftar Transaksi',
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        $services = Service::orderBy('service_name', 'asc')->get();
        $users    = User::orderBy('name', 'asc')->get();

        return view('transactions.create', [
            'judul'    => 'Tambah Transaksi Baru',
            'services' => $services,
            'users'    => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id',
            'service_ids'       => 'required|array|min:1',
            'service_ids.*'     => 'exists:services,id',
            'tanggal_transaksi' => 'required|date',
            'status'            => 'required|in:pending,completed,cancelled',
        ]);

        $transaction = new Transaction();
        $transaction->user_id           = $request->get('user_id');
        $transaction->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaction->status            = $request->get('status');
        $transaction->save();

        $transaction->services()->sync($request->get('service_ids'));

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaction)
    {
        $services = Service::orderBy('service_name', 'asc')->get();
        $users    = User::orderBy('name', 'asc')->get();

        // ID service yang sudah terpilih sebelumnya
        $selectedServiceIds = $transaction->services->pluck('id')->toArray();

        return view('transactions.edit', [
            'judul'              => 'Edit Transaksi',
            'transaction'        => $transaction,
            'services'           => $services,
            'users'              => $users,
            'selectedServiceIds' => $selectedServiceIds,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id'           => 'required|exists:users,id',
            'service_ids'       => 'required|array|min:1',
            'service_ids.*'     => 'exists:services,id',
            'tanggal_transaksi' => 'required|date',
            'status'            => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->user_id           = $request->get('user_id');
        $transaction->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaction->status            = $request->get('status');
        $transaction->save();

        $transaction->services()->sync($request->get('service_ids'));

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->services()->detach(); // hapus pivot dulu
            $transaction->delete();
            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');
        } catch (\PDOException $ex) {
            return redirect()->route('transactions.index')
                ->with('status', 'Tidak dapat menghapus transaksi ini.');
        }
    }
}
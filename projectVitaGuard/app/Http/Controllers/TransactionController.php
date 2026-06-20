<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'services'])->orderBy('tanggal_transaksi', 'desc')->get();
        
        $services = Service::orderBy('service_name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('transactions.index', [
            'judul' => 'Portal Manajemen: Daftar Transaksi',
            'transactions' => $transactions,
            'services' => $services,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_ids' => 'required|array|min:1',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction = new Transaction();
        $transaction->user_id = $request->get('user_id');
        $transaction->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaction->status = $request->get('status');
        $transaction->save();

        $transaction->services()->sync($request->get('service_ids'));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_ids' => 'required|array|min:1',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->user_id = $request->get('user_id');
        $transaction->tanggal_transaksi = $request->get('tanggal_transaksi');
        $transaction->status = $request->get('status');
        $transaction->save();

        $transaction->services()->sync($request->get('service_ids'));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete-permission', Auth::user());
        try {
            $transaction->services()->detach();
            $transaction->delete();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\PDOException $ex) {
            return redirect()->route('transactions.index')->with('status', 'Tidak dapat menghapus transaksi ini.');
        }
    }

    public function getEditForm(Request $request)
    {
        $data = Transaction::with('services')->find($request->id);
        $users = User::orderBy('name', 'asc')->get();
        $services = Service::orderBy('service_name', 'asc')->get();
        $selectedServiceIds = $data->services->pluck('id')->toArray();

        return response()->json([
            'status' => 'oke',
            'msg' => view('transactions.getEditForm', compact('data', 'users', 'services', 'selectedServiceIds'))->render(),
        ], 200);
    }

    public function getEditFormB(Request $request)
    {
        $data = Transaction::with('services')->find($request->id);
        $users = User::orderBy('name', 'asc')->get();
        $services = Service::orderBy('service_name', 'asc')->get();
        $selectedServiceIds = $data->services->pluck('id')->toArray();

        return response()->json([
            'status' => 'oke',
            'msg' => view('transactions.getEditFormB', compact('data', 'users', 'services', 'selectedServiceIds'))->render(),
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $data = Transaction::find($request->id);
        if (!$data)
            return response()->json(['status' => 'not_found', 'msg' => 'Data tidak ditemukan.'], 404);

        $data->user_id = $request->user_id;
        $data->tanggal_transaksi = $request->tanggal_transaksi;
        $data->status = $request->status;
        $data->save();

        $data->services()->sync($request->service_ids);

        $data->load('user', 'services');

        $servicesHtml = '';
        if ($data->services->count() > 0) {
            foreach ($data->services as $s) {
                $servicesHtml .= '<span class="badge bg-primary mb-1 me-1">' . $s->service_name . '</span> ';
            }
        } else {
            $servicesHtml = '<span class="text-muted">-</span>';
        }

        $statusHtml = '';
        if ($data->status === 'completed') {
            $statusHtml = '<span class="badge bg-success">Completed</span>';
        } elseif ($data->status === 'pending') {
            $statusHtml = '<span class="badge bg-warning text-dark">Pending</span>';
        } else {
            $statusHtml = '<span class="badge bg-danger">Cancelled</span>';
        }

        return response()->json([
            'status' => 'oke',
            'msg' => 'Transaksi berhasil diupdate!',
            'user_name' => $data->user->name ?? '-',
            'services_html' => $servicesHtml,
            'tanggal' => $data->tanggal_transaksi,
            'status_html' => $statusHtml
        ], 200);
    }

    public function deleteData(Request $request)
    {
        $data = Transaction::find($request->id);
        if (!$data)
            return response()->json(['status' => 'error', 'msg' => 'Data tidak ditemukan.'], 404);

        $data->services()->detach();
        $data->delete();

        return response()->json(['status' => 'oke', 'msg' => 'Transaksi berhasil dihapus!'], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Form booking (Member)
    public function create($doctor_id)
    {
        $doctor = Doctor::findOrFail($doctor_id);
        $memberId = Auth::id();

        $existingBooking = Booking::where('member_id', $memberId)
            ->where('doctor_id', $doctor_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        return view('member.booking_create', compact('doctor', 'existingBooking'));
    }

    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'jadwal' => 'required|date'
        ]);

        $memberId = Auth::id();

        $existingBooking = Booking::where('member_id', $memberId)
            ->where('doctor_id', $request->doctor_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingBooking) {
            $existingBooking->update(['jadwal' => $request->jadwal]);
            return redirect()->route('member.history')->with('success', 'Jadwal Booking berhasil di-reschedule!');
        }

        Booking::create([
            'doctor_id' => $request->doctor_id,
            'member_id' => Auth::id(),
            'jadwal' => $request->jadwal,
            'status' => 'pending',
        ]);

        return redirect()->route('member.history')->with('success', 'Booking berhasil dibuat!');
    }

    public function history()
    {
        $user = Auth::user();
        $bookings = Booking::with('doctor')
            ->where('member_id', $user->id)
            ->orderByRaw("CASE WHEN status IN ('pending', 'accepted') THEN 1 ELSE 2 END")
            ->orderBy('jadwal', 'desc')
            ->get();

        $transactions = collect();
        try {
            $transactions = Transaction::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            $transactions = collect();
        }
        return view('member.history', compact('bookings', 'transactions'));
    }

    public function indexDoctor()
    {
        $user = Auth::user();
        $doctor = Doctor::where('nama', $user->name)->first();

        if (!$doctor) {
            return redirect()->route('dokter.dashboard')->with('error', 'Profil dokter tidak ditemukan.');
        }

        $bookings = Booking::where('doctor_id', $doctor->id)
            ->orderByRaw("CASE WHEN status IN ('pending', 'accepted') THEN 1 ELSE 2 END")
            ->orderBy('jadwal', 'asc')
            ->get();

        return view('doctors.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:accepted,rejected,completed'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        if (auth()->user()->role === 'dokter') {
            return redirect()->route('dokter.bookings')->with('success', 'Status berhasil diupdate!');
        }

        return redirect()->back()->with('success', 'Status jadwal berhasil diubah menjadi ' . strtoupper($request->status) . '!');
    }

    public function indexAdmin()
    {
        // Mengambil semua data booking dengan relasi dokter dan member
        $bookings = Booking::with(['doctor', 'member'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('consultations.index', compact('bookings'));
    }
    public function destroy($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $booking->delete();

        return redirect()->back()->with('success', 'Data diarsipkan.');
    }
    public function trashed()
    {
        $bookings = Booking::onlyTrashed()->with(['doctor', 'member'])->get();

        return view('consultations.trashed', compact('bookings'));
    }

    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();

        return redirect()->route('consultations.index')->with('success', 'Data berhasil dipulihkan.');
    }
}

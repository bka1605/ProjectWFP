<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ConsultationMessage;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function show($id)
    {
        $booking = Booking::with(['doctor', 'member', 'messages.sender'])->findOrFail($id);

        $user = Auth::user();

        $isMemberOwner = ($user->role === 'member' && $booking->member_id === $user->id);

        $isDoctorOwner = false;
        if ($user->role === 'dokter') {
            $dokter = Doctor::where('nama', $user->name)->first();
            if ($dokter && $booking->doctor_id === $dokter->id) {
                $isDoctorOwner = true;
            }
        }

        if (!$isMemberOwner && !$isDoctorOwner) {
            abort(403);
        }

        if ($booking->status !== 'accepted' && $booking->status !== 'completed') {
            return redirect()->back()->with('error', 'Konsultasi belum bisa dimulai. Menunggu booking disetujui dokter.');
        }

        $viewName = $user->role === 'dokter' ? 'doctors.consultation' : 'member.consultation';

        return view($viewName, [
            'judul'   => 'Konsultasi Online - VitaGuard',
            'booking' => $booking,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'pesan'      => 'required|string|max:2000',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $user = Auth::user();

        $isMemberOwner = ($user->role === 'member' && $booking->member_id === $user->id);
        $isDoctorOwner = false;
        if ($user->role === 'dokter') {
            $dokter = Doctor::where('nama', $user->name)->first();
            $isDoctorOwner = $dokter && $booking->doctor_id === $dokter->id;
        }

        if (!$isMemberOwner && !$isDoctorOwner) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Anda tidak memiliki akses ke konsultasi ini.',
            ], 403);
        }

        if ($booking->status === 'rejected') {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Konsultasi ini sudah ditutup / ditolak.',
            ], 422);
        }

        $message = ConsultationMessage::create([
            'booking_id' => $booking->id,
            'sender_id'  => $user->id,
            'pesan'      => $request->pesan,
        ]);

        $html = view('consultations.bubble', [
            'message' => $message,
            'user'    => $user,
        ])->render();

        return response()->json([
            'status' => 'oke',
            'html'   => $html,
        ], 200);
    }

    public function fetchMessages(Request $request, $id)
    {
        $booking = Booking::with('messages.sender')->findOrFail($id);
        $user = Auth::user();

        $isMemberOwner = ($user->role === 'member' && $booking->member_id === $user->id);
        $isDoctorOwner = false;
        if ($user->role === 'dokter') {
            $dokter = Doctor::where('nama', $user->name)->first();
            $isDoctorOwner = $dokter && $booking->doctor_id === $dokter->id;
        }

        if (!$isMemberOwner && !$isDoctorOwner) {
            return response()->json(['status' => 'error'], 403);
        }

        $html = '';
        foreach ($booking->messages as $message) {
            $html .= view('consultations.bubble', [
                'message' => $message,
                'user'    => $user,
            ])->render();
        }

        return response()->json([
            'status' => 'oke',
            'html'   => $html,
            'booking_status' => $booking->status,
        ], 200);
    }

    public function close(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        $dokter = Doctor::where('nama', $user->name)->first();
        if (!$dokter || $booking->doctor_id !== $dokter->id) {
            abort(403);
        }

        $booking->update([
            'status'    => 'completed',
            'closed_at' => now(),
        ]);

        return redirect()->route('dokter.bookings')->with('success', 'Konsultasi telah ditutup dan tersimpan di riwayat.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranSeminar;
use App\Models\Seminar;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        // Pastikan user login
        if (!session()->has('auth_user')) {
            return redirect()->route('login.choose')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'seminar_id' => 'required|integer|exists:seminar,id'
        ]);

        $auth = session('auth_user');
        $userId = $auth['id'];
        $userType = $auth['role'];

        // Cek apakah sudah terdaftar
        $exists = PendaftaranSeminar::where('seminar_id', $request->seminar_id)
            ->where('user_id', $userId)
            ->where('user_type', $userType)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah terdaftar pada seminar ini.');
        }

        // Buat pendaftaran
        PendaftaranSeminar::create([
            'seminar_id' => $request->seminar_id,
            'user_id' => $userId,
            'user_type' => $userType,
            'status_sertifikat' => null,
        ]);

        // Increment jumlah_pendaftar di tabel seminar
        Seminar::where('id', $request->seminar_id)->increment('jumlah_pendaftar');

        return back()->with('success', 'Pendaftaran seminar berhasil.');
    }
}

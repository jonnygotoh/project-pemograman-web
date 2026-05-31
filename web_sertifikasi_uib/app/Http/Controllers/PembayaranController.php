<?php

namespace App\Http\Controllers;

use App\Models\PembayaranSertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi hanya untuk field yang penting
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
            'sertifikasi_id' => 'required'
        ]);

        // 2. Upload file
        $file = $request->file('bukti_bayar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti_bayar', $filename);

        // 3. Simpan ke database (Hanya data yang ada di $fillable Model)
        PembayaranSertifikasi::create([
            'user_id'        => session('auth_user')['id'],
            'user_type'      => session('auth_user')['role'],
            'sertifikasi_id' => $request->sertifikasi_id,
            'bukti_bayar'    => $filename,
            'status'         => 'menunggu',
            // Field lain dari form (bank_name, dsb) otomatis diabaikan oleh Laravel
        ]);

        return redirect()->route('profile')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function destroy($id)
    {
        $pembayaran = PembayaranSertifikasi::where('id', $id)
                        ->where('user_id', session('auth_user')['id'])
                        ->where('user_type', session('auth_user')['role'])
                        ->firstOrFail();

        if ($pembayaran->bukti_bayar) {
            Storage::delete('public/bukti_bayar/' . $pembayaran->bukti_bayar);
        }
        
        $pembayaran->delete();
        
        return back()->with('success', 'Pendaftaran dibatalkan.');
    }
}
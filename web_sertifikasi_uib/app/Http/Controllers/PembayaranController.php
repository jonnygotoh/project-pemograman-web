<?php

namespace App\Http\Controllers;

use App\Models\PembayaranSertifikasi;
use App\Models\PendaftaranSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        // A. LOGIKA SEMINAR
        if ($request->has('seminar_id')) {
            \App\Models\PendaftaranSeminar::create([
                'seminar_id' => $request->seminar_id,
                'user_id'    => session('auth_user')['id'],
                'user_type'  => session('auth_user')['role'],
            ]);
            return redirect()->route('profile')->with('success', 'Berhasil mendaftar Seminar!');
        }

        // B. LOGIKA SERTIFIKASI
        // 1. Validasi ukuran file (Max 2MB)
        $request->validate([
            'bukti_bayar'    => 'required|file|max:2048',
            'sertifikasi_id' => 'required'
        ], [
            'bukti_bayar.max' => 'Ukuran file terlalu besar! Maksimal 2MB.',
        ]);

        $file = $request->file('bukti_bayar');

        // 2. CEK MIME TYPE ASLI (Mencegah video/dokumen)
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file->getClientMimeType(), $allowedMimes)) {
            return redirect()->back()->with('error', 'Format tidak didukung! Hanya JPG, JPEG, atau PNG yang diizinkan.');
        }

        // 3. CEK INTEGRITAS (Mencegah file video/lainnya yang namanya di-rename)
        if (@getimagesize($file->getRealPath()) === false) {
            return redirect()->back()->with('error', 'File yang diunggah bukan gambar yang valid!');
        }

        // 4. Proses Simpan
        $filename = time() . '_' . $file->getClientOriginalName();
        
        if ($file->storeAs('bukti_bayar', $filename, 'public')) {
            PembayaranSertifikasi::create([
                'user_id'        => session('auth_user')['id'],
                'user_type'      => session('auth_user')['role'],
                'sertifikasi_id' => $request->sertifikasi_id,
                'bukti_bayar'    => $filename,
                'status'         => 'menunggu',
            ]);
            return redirect()->route('profile')->with('success', 'Pendaftaran berhasil! Menunggu verifikasi.');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah file.');
    }
    
    public function destroy($id)
    {
        $pembayaran = PembayaranSertifikasi::where('id', $id)
                        ->where('user_id', session('auth_user')['id'])
                        ->firstOrFail();

        if ($pembayaran->bukti_bayar) {
            Storage::disk('public')->delete('bukti_bayar/' . $pembayaran->bukti_bayar);
        }
        
        $pembayaran->delete();
        return back()->with('success', 'Pendaftaran dibatalkan.');
    }

    public function viewBuktiBayar($filename)
    {
        $path = 'bukti_bayar/' . $filename;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(Storage::disk('public')->path($path));
    }
}
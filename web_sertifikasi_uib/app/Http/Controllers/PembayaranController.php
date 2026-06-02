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
        try {
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
            $request->validate([
                'bukti_bayar' => 'required|image|max:2048',
                'sertifikasi_id' => 'required'
            ]);

            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file
            if ($file->storeAs('bukti_bayar', $filename, 'public')) {
                \App\Models\PembayaranSertifikasi::create([
                    'user_id'        => session('auth_user')['id'],
                    'user_type'      => session('auth_user')['role'],
                    'sertifikasi_id' => $request->sertifikasi_id,
                    'bukti_bayar'    => $filename,
                    'status'         => 'menunggu',
                ]);
                return redirect()->route('profile')->with('success', 'Pendaftaran Sertifikasi berhasil! Menunggu verifikasi.');
            } else {
                throw new \Exception("Gagal mengunggah file.");
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Menangkap error validasi (misal: file bukan gambar atau terlalu besar)
            return redirect()->back()->with('error', 'Validasi gagal: Pastikan file berupa gambar (jpg/png) dan ukuran maksimal 2MB.');
        } catch (\Exception $e) {
            // Menangkap error lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
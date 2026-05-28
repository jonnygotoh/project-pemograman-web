<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $seminars = \App\Models\Seminar::all();
        $sertifikasis = \App\Models\Sertifikasi::all();

        return view('pages.dashboardAdmin', compact('seminars', 'sertifikasis'));    
    }
    
    // =====================
    // MANAJEMEN SEMINAR
    // =====================

    public function seminarStore(Request $request)
    {
        Seminar::create([
            'nama' => $request->nama,
            'periode' => $request->periode,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tipe' => $request->tipe,
        ]);

        // Setelah sukses simpan, lempar kembali ke home dengan pesan sukses
        return redirect()->route('home')->with('success', 'Data Seminar berhasil ditambahkan!');
    }

    public function seminarUpdate(Request $request, $id)
    {
        Seminar::find($id)->update($request->all());

        // Setelah sukses update, lempar kembali ke home
        return redirect()->route('home')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();

        // Setelah sukses hapus, lempar kembali ke home
        return redirect()->route('home')->with('success', 'Data Seminar berhasil dihapus!');
    }

    // =====================
    // MANAJEMEN SERTIFIKASI
    // =====================

    // =====================
    // MANAJEMEN SERTIFIKASI (Sudah Sinkron dengan Migration Kamu)
    // =====================

    public function sertifikasiStore(Request $request)
    {
        Sertifikasi::create([
            'nama' => $request->nama,
            'batch' => $request->batch,
            'periode' => $request->periode,
            'waktu' => $request->waktu, // Menggunakan 'waktu' sebagai tanggal (tipe date)
            'biaya_mahasiswa' => $request->biaya_mahasiswa,
            'biaya_dosen' => $request->biaya_dosen,
            'biaya_umum' => $request->biaya_umum,
        ]);

        return redirect()->route('home')->with('success', 'Data Sertifikasi berhasil ditambahkan!');
    }

    public function sertifikasiUpdate(Request $request, $id)
    {
        Sertifikasi::find($id)->update($request->all());

        return redirect()->route('home')->with('success', 'Data Sertifikasi berhasil diubah!');
    }

    public function sertifikasiDelete($id)
    {
        Sertifikasi::find($id)->delete();

        return redirect()->route('home')->with('success', 'Data Sertifikasi berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function seminarStore(Request $request)
    {
        Seminar::create([
            'nama' => $request->nama,
            'batch' => $request->batch,
            'periode' => $request->periode,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'biaya' => $request->biaya
        ]);
    }

    public function seminarUpdate(Request $request, $id)
    {
        Seminar::find($id)->update($request->all());
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();
    }

    // =====================
    // SERTIFIKASI (NYAMBUNG KE HOME $certificationRows)
    // =====================

    public function sertifikasiStore(Request $request)
    {
        Sertifikasi::create([
            'nama' => $request->nama,
            'batch' => $request->batch,
            'periode' => $request->periode,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'biaya' => $request->biaya
        ]);
    }

    public function sertifikasiUpdate(Request $request, $id)
    {
        Sertifikasi::find($id)->update($request->all());
    }

    public function sertifikasiDelete($id)
    {
        Sertifikasi::find($id)->delete();
    }
}


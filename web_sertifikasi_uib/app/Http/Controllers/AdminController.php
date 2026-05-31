<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\CalendarHelper;

class AdminController extends Controller
{
    use CalendarHelper; 

    public function dashboard(Request $request)
    {
        $month = $request->month ?? 6;
        $year = $request->year ?? 2026;

        return view('pages.dashboardAdmin', [
            'month' => $month,
            'year' => $year,
            // Menggunakan helper mapping agar format data seragam dengan tabel di Home
            'seminarRows' => $this->getSeminarRows(),
            'certificationRows' => $this->getCertificationRows(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),
        ]);
    }

    // Helper untuk memformat data seminar agar siap masuk ke 'table.blade.php'
    private function getSeminarRows() {
        return Seminar::all()->map(function ($s, $index) {
            return (object) [
                'id' => $s->id,
                'no' => $index + 1,
                'nama' => $s->nama,
                'periode' => $s->periode,
                'waktu' => $s->tanggal ? Carbon::parse($s->tanggal)->format('d M Y') : '-',
                'biaya' => $s->tipe === 'free' ? 'Gratis' : 'Rp ' . number_format($s->biaya, 0, ',', '.'),
                'jumlah_pendaftar' => $s->jumlah_pendaftar
            ];
        });
    }

    // Helper untuk memformat data sertifikasi agar siap masuk ke 'table.blade.php'
    private function getCertificationRows() {
        return Sertifikasi::all()->map(function ($s, $index) {
            return (object) [
                'id' => $s->id,
                'no' => $index + 1,
                'nama' => $s->nama,
                'periode' => $s->periode,
                'waktu' => $s->waktu ? Carbon::parse($s->waktu)->format('d M Y') : '-',
                'biaya' => "Mhs: Rp" . number_format($s->biaya_mahasiswa, 0, ',', '.') . " | Dosen: Rp" . number_format($s->biaya_dosen, 0, ',', '.') . " | Umum: Rp" . number_format($s->biaya_umum, 0, ',', '.'),
                'jumlah_pendaftar' => $s->jumlah_pendaftar
            ];
        });
    }

// =====================
// SERTIFIKASI
// =====================

    public function seminarCreate() {
        return view('crud.seminar');
    }
    public function seminarEdit($id) {
        $item = Seminar::findOrFail($id);
        return view('crud.seminar', compact('item'));
    }

    public function seminarStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'periode' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tipe' => 'required',
            'biaya' => 'nullable|numeric',
        ]);

        $data['jumlah_pendaftar'] = 0; 

        if ($request->tipe === 'free') {
            $data['biaya'] = 0;
        }

        Seminar::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil ditambahkan!');
    }

    public function seminarUpdate(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $data = $request->all();
        
        if ($request->tipe === 'free') {
            $data['biaya'] = 0;
        }

        $seminar->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();

        // Setelah sukses hapus, lempar kembali ke home
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil dihapus!');
    }

    // =====================
    // SERTIFIKASI
    // =====================

    public function sertifikasiCreate() {
        return view('crud.sertifikasi');
    }

    public function sertifikasiEdit($id) {
        $item = Sertifikasi::findOrFail($id);
        return view('crud.sertifikasi', compact('item'));
    }
    
    public function sertifikasiStore(Request $request)
    {

        $validated = $request->validate([
            'nama' => 'required',
            'batch' => 'nullable',
            'periode' => 'required',
            'waktu' => 'required|date',
            'biaya_mahasiswa' => 'required|numeric',
            'biaya_dosen' => 'required|numeric',
            'biaya_umum' => 'required|numeric',
        ]);

        $validated['jumlah_pendaftar'] = 0;

        Sertifikasi::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil ditambahkan!');
    }

    public function sertifikasiUpdate(Request $request, $id)
    {
        $sertif = Sertifikasi::findOrFail($id);
        $sertif->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil diubah!');
    }

    public function sertifikasiDelete($id)
    {
        Sertifikasi::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil dihapus!');
    }
}
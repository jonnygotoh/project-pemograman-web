<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $month = $request->month ?? 5;
        $year = $request->year ?? 2026;

        $data = [
            'month' => $month,
            'year' => $year,
            'seminarRows' => \App\Models\Seminar::all(),
            'certificationRows' => \App\Models\Sertifikasi::all(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),
        ];

        return view('pages.dashboardAdmin', $data);
    }

    private function seminarRows() {
        return Seminar::all();
    }

    private function certificationRows() {
        return Sertifikasi::all();
    }

    private function generateCalendar($month, $year, $type) {
        $days = [];
        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        $startDay = $date->dayOfWeek;

        for ($i = 0; $i < $startDay; $i++) {
            $days[] = ['date' => '', 'muted' => true, 'events' => []];
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $hasEvent = in_array($i, $type === 'seminar' ? [10, 11, 17, 18] : [7, 12, 23, 26]);
            $days[] = [
                'date' => $i,
                'events' => $hasEvent ? [['title' => ucfirst($type) . ' Event', 'url' => '#']] : []
            ];
        }
        return $days;
    }

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
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil ditambahkan!');
    }

    public function seminarUpdate(Request $request, $id)
    {
        Seminar::find($id)->update($request->all());

        // Setelah sukses update, lempar kembali ke home
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function seminarDelete($id)
    {
        Seminar::find($id)->delete();

        // Setelah sukses hapus, lempar kembali ke home
        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil dihapus!');
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

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil ditambahkan!');
    }

    public function sertifikasiUpdate(Request $request, $id)
    {
        Sertifikasi::find($id)->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data Seminar berhasil diubah!');
    }

    public function sertifikasiDelete($id)
    {
        Sertifikasi::find($id)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data Sertifikasi berhasil dihapus!');
    }
}
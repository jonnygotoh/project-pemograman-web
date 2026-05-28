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

    private function generateCalendar($month, $year, $type)
    {
        $days = [];
        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        $startDay = $date->dayOfWeek;

        // Ambil semua event berdasarkan bulan dan tahun yang dipilih
        if ($type === 'seminar') {
            $events = Seminar::whereMonth('tanggal', $month)
                            ->whereYear('tanggal', $year)
                            ->get();
        } else {
            $events = Sertifikasi::whereMonth('waktu', $month)
                                ->whereYear('waktu', $year)
                                ->get();
        }

        // Buat pemetaan tanggal ke event
        $eventMap = [];
        foreach ($events as $event) {
            $eventDate = Carbon::parse($type === 'seminar' ? $event->tanggal : $event->waktu)->day;
            $eventMap[$eventDate][] = [
                'title' => $event->nama,
                'url' => '#'
            ];
        }

        for ($i = 0; $i < $startDay; $i++) {
            $days[] = ['date' => '', 'muted' => true, 'events' => []];
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = [
                'date' => $i,
                'events' => $eventMap[$i] ?? [] // Mengambil event dari map jika ada
            ];
        }

        return $days;
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
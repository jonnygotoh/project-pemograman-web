<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $month = $request->month ?? 6;
        $year = $request->year ?? 2026;
        $data = $this->landingData($month, $year);

        return view('pages.home', $data);
    }

   public function calendar(Request $request, $type)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $calendarDays = $this->generateCalendar($month, $year, $type);

        return view('pages.partials.calendar', [
            'type' => $type,
            'month' => $month,
            'year' => $year,
            'calendarDays' => $calendarDays
        ]);
    }

    private function landingData($month, $year)
    {
        return [
            'month' => $month,
            'year' => $year,
            'seminarRows' => $this->seminarRows(),
            'certificationRows' => $this->certificationRows(),
            'seminarCalendar' => $this->generateCalendar($month, $year, 'seminar'),
            'certificationCalendar' => $this->generateCalendar($month, $year, 'sertifikasi'),
        ];
    }

    private function seminarRows()
    {
        return Seminar::all()->map(function ($seminar, $index) {
            return [
                'id' => $seminar->id,
                'no' => $index + 1,
                'nama' => $seminar->nama,
                'periode' => $seminar->periode,
                'tanggal' => $seminar->tanggal ? Carbon::parse($seminar->tanggal)->format('d M Y') : '-',
                'waktu' => $seminar->waktu,
                'biaya' => $seminar->tipe === 'free' ? 'Gratis' : 'Rp ' . number_format($seminar->biaya, 0, ',', '.'),
                'jumlah_pendaftar' => $seminar->jumlah_pendaftar 
            ];
        });
    }

    private function certificationRows()
    {
        return Sertifikasi::all()->map(function ($sertif, $index) {
            return [
                'id' => $sertif->id,
                'no' => $index + 1,
                'nama' => $sertif->nama,
                'periode' => $sertif->periode,
                'waktu' => $sertif->waktu ? Carbon::parse($sertif->waktu)->format('d M Y') : '-',
                'biaya' => "Mhs: Rp" . number_format($sertif->biaya_mahasiswa, 0, ',', '.') . 
                        " | Dosen: Rp" . number_format($sertif->biaya_dosen, 0, ',', '.') . 
                        " | Umum: Rp" . number_format($sertif->biaya_umum, 0, ',', '.'),
                // Sekarang sudah berisi data asli dari database
                'jumlah_pendaftar' => $sertif->jumlah_pendaftar 
            ];
        });
    }

    private function generateCalendar($month, $year, $type)
    {
        $days = [];
        $date = Carbon::create($year, $month, 1);

        $daysInMonth = $date->daysInMonth;
        $startDay = $date->dayOfWeek;

        // 1. GET EVENTS
        if ($type === 'seminar') {
            $events = Seminar::whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->get();
        } else {
            $events = Sertifikasi::whereMonth('waktu', $month)
                ->whereYear('waktu', $year)
                ->get();
        }

        // 2. MAP EVENTS
        $eventMap = [];

        foreach ($events as $event) {
            $eventDate = Carbon::parse(
                $type === 'seminar'
                    ? $event->tanggal
                    : $event->waktu
            )->day;

            $eventMap[$eventDate][] = [
                'id' => $event->id,
                'title' => $event->nama,
                'url' => $type === 'seminar'
                    ? route('seminar.show', $event->id)
                    : route('sertifikasi.show', $event->id),
            ];
        }

        // 3. EMPTY DAYS
        for ($i = 0; $i < $startDay; $i++) {
            $days[] = [
                'date' => '',
                'muted' => true,
                'events' => []
            ];
        }

        // 4. DAYS IN MONTH
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = [
                'date' => $i,
                'events' => $eventMap[$i] ?? []
            ];
        }

        return $days;
        }

    //menampilkan detail seminar/sertifikasi
 public function showSeminar($id)
{
    $seminar = Seminar::findOrFail($id);

    $event = [
        'title' => $seminar->nama,
        'description' => $seminar->deskripsi ?? '-',
        'date' => $seminar->tanggal,
        'time' => $seminar->waktu,
        'place' => $seminar->tempat ?? '-',
        'mode' => $seminar->mode ?? 'offline',
        'poster' => $seminar->poster ?? null,
    ];

    return view('pages.detail', compact('event'));
}

    public function showSertifikasi($id)
    {
        $sertif = Sertifikasi::findOrFail($id);

        $event = [
            'title' => $sertif->nama,
            'description' => $sertif->deskripsi ?? '-',
            'date' => $sertif->waktu,
            'time' => $sertif->jam ?? '-',
            'place' => $sertif->tempat ?? '-',
            'mode' => $sertif->mode ?? 'offline',
            'poster' => $sertif->poster ?? null,
        ];

        return view('pages.detail', compact('event'));
    }

 }
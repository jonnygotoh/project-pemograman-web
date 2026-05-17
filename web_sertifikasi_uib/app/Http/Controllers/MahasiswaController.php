<?php

namespace App\Http\Controllers;

class MahasiswaController extends Controller
{
    public function home()
    {
        return view('pages.home', $this->landingData());
    }

    public function mahasiswa()
    {
        return view('mahasiswa.index');
    }

    private function landingData()
    {
        return [
            'seminarRows' => $this->seminarRows(),
            'certificationRows' => $this->certificationRows(),
            'seminarCalendar' => $this->demoCalendarDays('seminar'),
            'certificationCalendar' => $this->demoCalendarDays('sertifikasi'),
            'news' => $this->news(),
        ];
    }

    private function seminarRows()
    {
        return [
            ['Webinar AI', '07 - 12 Mei', '12 Mei', '18:00', 'Online', 'Free', '10', '<a href="#">Daftar</a>']
        ];
    }

    private function certificationRows()
    {
        return [
            ['TOEIC Test', '07 - 12 Mei', '23 Mei', '09:00', 'Rp 500.000', '24', '<a href="#">Daftar</a>']
        ];
    }

    private function demoCalendarDays($type)
    {
        $days = [];

        for ($i = 1; $i <= 30; $i++) {

            $hasEvent = in_array($i, $type === 'seminar'
                ? [10, 11, 17, 18]
                : [7, 12, 23, 26]
            );

            $days[] = [
                'date' => $i,
                'events' => $hasEvent ? [
                    [
                        'title' => ucfirst($type) . ' Event',
                        'url' => '#'
                    ]
                ] : []
            ];
        }

        return $days;
    }

    private function news()
    {
        return [
            [
                'image' => asset('images/news.png'),
                'date' => '16 Mei 2026',
                'title' => 'Info Seminar Terbaru',
                'summary' => 'Pendaftaran seminar sudah dibuka.'
            ]
        ];
    }
}
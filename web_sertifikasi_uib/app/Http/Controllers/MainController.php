<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Sertifikasi;

class MainController extends Controller
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
        ];
    }

    private function seminarRows()
    {
        return Seminar::all();
    }

    private function certificationRows()
    {
        return Sertifikasi::all();
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
}
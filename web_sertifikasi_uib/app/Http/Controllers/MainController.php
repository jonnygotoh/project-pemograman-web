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
        $month = $request->month ?? 5;
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
        return Seminar::all();
    }

    private function certificationRows()
    {
        return Sertifikasi::all();
    }

    private function generateCalendar($month, $year, $type)
    {
        $days = [];

        $date = Carbon::create($year, $month, 1);

        $daysInMonth = $date->daysInMonth;

        $startDay = $date->dayOfWeek;

        for ($i = 0; $i < $startDay; $i++) {
            $days[] = [
                'date' => '',
                'muted' => true,
                'events' => []
            ];
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {

            $hasEvent = in_array($i,
                $type === 'seminar'
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
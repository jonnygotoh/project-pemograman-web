<?php

namespace App\Traits;

use App\Models\Seminar;
use App\Models\Sertifikasi;
use Carbon\Carbon;

trait CalendarHelper
{
    public function generateCalendar($month, $year, $type)
    {
        $days = [];
        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        $startDay = $date->dayOfWeek;

        // 1. Ambil Events
        if ($type === 'seminar') {
            $events = Seminar::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();
        } else {
            $events = Sertifikasi::whereMonth('waktu', $month)->whereYear('waktu', $year)->get();
        }

        // 2. Pemetaan Tanggal ke Event
        $eventMap = [];
        foreach ($events as $event) {
            $eventDate = Carbon::parse($type === 'seminar' ? $event->tanggal : $event->waktu)->day;
            $eventMap[$eventDate][] = [
                'id' => $event->id,
                'title' => $event->nama,
                // Gunakan route yang sudah ada di sistem
                'url' => $type === 'seminar' 
                    ? route('seminar.show', $event->id) 
                    : route('sertifikasi.show', $event->id),
            ];
        }

        // 3. Loop Hari
        for ($i = 0; $i < $startDay; $i++) {
            $days[] = ['date' => '', 'muted' => true, 'events' => []];
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $days[] = [
                'date' => $i,
                'events' => $eventMap[$i] ?? []
            ];
        }

        return $days;
    }
}
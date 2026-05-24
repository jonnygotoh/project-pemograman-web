@php
    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;

    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;
@endphp

<div class="calendar-card">

    <div class="calendar-head">

        <a href="{{ route('home', [
            'type' => $type,
            'month' => $prevMonth,
            'year' => $prevYear
        ]) }}">
            <i data-lucide="chevron-left"></i>
        </a>

        <h2>
            {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
        </h2>

        <div>

            <a href="{{ route('home', [
                'type' => $type,
                'month' => $nextMonth,
                'year' => $nextYear
            ]) }}">
                <i data-lucide="chevron-right"></i>
            </a>

        </div>
    </div>

    <div class="calendar-grid">

        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
            <div class="calendar-day-name">{{ $day }}</div>
        @endforeach

        @foreach($calendarDays as $day)
            <div class="calendar-cell {{ $day['muted'] ?? false ? 'muted' : '' }}">
                <strong>{{ $day['date'] }}</strong>

                @foreach($day['events'] ?? [] as $event)
                    <a class="calendar-event" href="#">
                        {{ $event['title'] }}
                    </a>
                @endforeach
            </div>
        @endforeach

    </div>
</div>
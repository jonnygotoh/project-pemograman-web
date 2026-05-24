@php
    $month = $month ?? now()->month;
    $year = $year ?? now()->year;

    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;

    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;
@endphp

<div class="calendar-card">

    <div class="calendar-head">

        <button type="button"
            onclick="changeMonth('{{ $type }}', {{ $prevMonth }}, {{ $prevYear }})">
            <i data-lucide="chevron-left"></i>
        </button>

        <h2>
            {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
        </h2>

        <button type="button"
            onclick="changeMonth('{{ $type }}', {{ $nextMonth }}, {{ $nextYear }})">
            <i data-lucide="chevron-right"></i>
        </button>

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
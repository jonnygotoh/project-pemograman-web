<div class="calendar-card">
    <div class="calendar-head">
        <button type="button"><i data-lucide="chevron-left"></i></button>
        <h2>{{ $monthTitle ?? 'May 2026' }} <i data-lucide="chevron-down"></i></h2>
        <div>
            <button type="button"><i data-lucide="chevron-right"></i></button>
            <button type="button">today</button>
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
                    <a class="calendar-event" href="{{ $event['url'] ?? route('event.detail') }}">{{ $event['title'] }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

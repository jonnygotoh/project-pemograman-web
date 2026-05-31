@php
    $month = $month ?? now()->month;
    $year = $year ?? now()->year;

    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;

    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;

    
    $currentYear = now()->year;

    $isPrevDisabled =
        ($year <= ($currentYear - 1) && $month <= 1);

    $isNextDisabled =
        ($year >= ($currentYear + 1) && $month >= 12);
@endphp

<div class="calendar-card">

    <div class="calendar-head">

        <button
            type="button"
            {{ $isPrevDisabled ? 'disabled' : '' }}
            @if(!$isPrevDisabled)
                onclick="changeMonth('{{ $type }}', {{ $prevMonth }}, {{ $prevYear }})"
            @endif
        >
            <i data-lucide="chevron-left"></i>
        </button>

        <div class="calendar-date-picker">

            <button type="button" class="calendar-picker-btn" id="{{ $type }}DatePickerBtn" data-month="{{ $month }}"
                data-year="{{ $year }}">
                <span id="{{ $type }}MonthYear"></span>
                <span class="calendar-picker-arrow">▾</span>
            </button>

            <div class="calendar-picker-dropdown" id="{{ $type }}DatePickerDropdown">

                <div class="calendar-picker-group">
                    <label>Bulan</label>

                    <select id="{{ $type }}MonthSelect">
                        @foreach([
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ] as $monthValue => $monthName)

                            <option value="{{ $monthValue }}">
                                {{ $monthName }}
                            </option>

                        @endforeach
                    </select>
                </div>

                <div class="calendar-picker-group">
                    <label>Tahun</label>
                    <select id="{{ $type }}YearSelect"></select>
                </div>

                <button type="button" class="calendar-go-btn" id="{{ $type }}GoDateBtn">
                    Pilih Tanggal
                </button>

            </div>

        </div>

        <button
            type="button"
            {{ $isNextDisabled ? 'disabled' : '' }}
            @if(!$isNextDisabled)
                onclick="changeMonth('{{ $type }}', {{ $nextMonth }}, {{ $nextYear }})"
            @endif
        >
            <i data-lucide="chevron-right"></i>
        </button>

    </div>
<div class="calendar-grid">

    @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
        <div class="calendar-day-name">{{ $day }}</div>
    @endforeach

    @foreach($calendarDays as $day)

        <div class="calendar-cell {{ $day['muted'] ?? false ? 'muted' : '' }}">

            <div class="calendar-date">
                {{ $day['date'] }}
            </div>

            @foreach($day['events'] as $event)
                <a class="calendar-event" href="{{ $event['url'] }}">
                    {{ $event['title'] }}
                </a>
            @endforeach

        </div>

    @endforeach

</div>

</div>
@extends('templates.main')
@section('title', $event['title'])

@section('content')
<section class="detail-hero">
    <h1>{{ strtoupper($event['title']) }}</h1>
</section>

<section class="detail-page">
    <div class="poster-card">
        <img src="{{ !empty($event['poster']) ? asset('images/' . $event['poster']) : asset('images/poster-default.jpg') }}" 
            alt="Poster untuk {{ $event['title'] }}">
    </div>

    <div class="detail-card">
        <h2>{{ $event['title'] }}</h2>
        <div class="yellow-line"></div>
        <p>{{ $event['description'] }}</p>

        <div class="detail-info-box">
            <h4>KEGIATAN INI AKAN DILAKSANAKAN SECARA “{{ strtoupper($event['mode'] ?? 'OFFLINE') }}” PADA:</h4>
            <p><i data-lucide="calendar-days"></i> <b>Hari/Tanggal:</b> {{ $event['date'] }}</p>
            <p><i data-lucide="clock"></i> <b>Waktu:</b> {{ $event['time'] }}</p>
            <p><i data-lucide="map-pin"></i> <b>Tempat:</b> {{ $event['place'] }}</p>

            @php
                $user = session('auth_user');
            @endphp

            @if(auth()->check() || session()->has('auth_user'))

                @if(($event['category'] ?? '') == 'sertifikasi')

                    @php
                        $sudahDaftarSertif = \App\Models\PembayaranSertifikasi::where('sertifikasi_id', $event['id'])
                            ->where('user_id', $user['id'] ?? null)
                            ->exists();
                    @endphp

                    @if($sudahDaftarSertif)
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">
                            SUDAH TERDAFTAR
                        </button>
                    @else
                        <a href="{{ route('upload.payment', ['sertifikasi_id' => $event['id']]) }}" class="btn-primary">
                            DAFTAR SERTIFIKASI <i data-lucide="arrow-right"></i>
                        </a>
                    @endif

                @else

                    @php
                        $sudahDaftarSeminar = \App\Models\PendaftaranSeminar::where('seminar_id', $event['id'])
                            ->where('user_id', $user['id'] ?? null)
                            ->exists();
                    @endphp

                    @if($sudahDaftarSeminar)
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">
                            SUDAH TERDAFTAR
                        </button>
                    @else
                        <form action="{{ route('pendaftaran.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="seminar_id" value="{{ $event['id'] }}">
                            <button type="submit" class="btn-primary">
                                DAFTAR SEMINAR <i data-lucide="arrow-right"></i>
                            </button>
                        </form>
                    @endif

                @endif

            @else
                <a href="{{ route('login.choose') }}" class="btn-primary">
                    LOGIN UNTUK DAFTAR <i data-lucide="log-in"></i>
                </a>
            @endif
        </div>
    </div>
</section>
@endsection
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
        <div class="yellow-line" style="width: 50px; height: 3px; background: #f39c12; margin-bottom: 15px;"></div>
        <p>{{ $event['description'] }}</p>

        <div class="detail-info-box">
            <h4>KEGIATAN INI AKAN DILAKSANAKAN SECARA “{{ strtoupper($event['mode'] ?? 'OFFLINE') }}” PADA:</h4>
            
            <p><i data-lucide="calendar-days"></i> <b>Hari/Tanggal:</b> {{ \Carbon\Carbon::parse($event['date'])->format('d F Y') }}</p>
            
            <p><i data-lucide="clock"></i> <b>Waktu:</b> {{ $event['time'] }}</p>
            <p><i data-lucide="map-pin"></i> <b>Tempat:</b> {{ $event['place'] }}</p>

            @php $user = session('auth_user'); @endphp

            @if(auth()->check() || session()->has('auth_user'))
                @if(($event['category'] ?? '') == 'sertifikasi')
                    @php
                        $sudahDaftarSertif = \App\Models\PembayaranSertifikasi::where('sertifikasi_id', $event['id'])
                            ->where('user_id', $user['id'] ?? null)
                            ->where('user_type', $user['role'] ?? null)
                            ->exists();
                    @endphp

                    @if($user['role'] === 'admin')
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">ADMIN TIDAK BISA DAFTAR</button>
                    @elseif($sudahDaftarSertif)
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">SUDAH TERDAFTAR</button>
                    @else
                        <a href="javascript:void(0)" class="btn-primary" 
                           onclick="confirmDaftar('{{ route('upload.payment', ['sertifikasi_id' => $event['id']]) }}', 'Sertifikasi')">
                           DAFTAR SERTIFIKASI <i data-lucide="arrow-right"></i>
                        </a>
                    @endif

                @else
                    @php
                        $sudahDaftarSeminar = \App\Models\PendaftaranSeminar::where('seminar_id', $event['id'])
                            ->where('user_id', $user['id'] ?? null)
                            ->where('user_type', $user['role'] ?? null)
                            ->exists();
                    @endphp

                    @if($user['role'] === 'admin')
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">ADMIN TIDAK BISA DAFTAR</button>
                    @elseif($sudahDaftarSeminar)
                        <button class="btn-primary" disabled style="opacity:0.6; cursor:not-allowed;">SUDAH TERDAFTAR</button>
                    @else
                        <a href="javascript:void(0)" class="btn-primary" onclick="confirmDaftarSeminar()">
                            DAFTAR SEMINAR <i data-lucide="arrow-right"></i>
                        </a>
                        <form id="form-seminar" action="{{ route('pendaftaran.seminar.store') }}" method="POST" style="display:none;">
                            @csrf
                            <input type="hidden" name="seminar_id" value="{{ $event['id'] }}">
                        </form>
                    @endif
                @endif
            @else
                <a href="{{ route('login.choose') }}" class="btn-primary">LOGIN UNTUK DAFTAR <i data-lucide="log-in"></i></a>
            @endif
        </div>
    </div>
</section>
@endsection
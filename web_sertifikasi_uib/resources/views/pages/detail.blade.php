@extends('layouts.app')
@section('title', $event['title'])

@section('content')
<section class="detail-hero">
    <h1>{{ strtoupper($event['title']) }}</h1>
</section>

<section class="detail-page">
    <div class="poster-card">
        <img src="{{ $event['poster'] ?? asset('images/poster-placeholder.png') }}" alt="Poster">
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

            <button class="btn-primary" onclick="{{ auth()->check() ? 'openConfirmRegister()' : 'openLoginRequired()' }}">
                DAFTAR SEKARANG <i data-lucide="arrow-right"></i>
            </button>
        </div>
    </div>
</section>
@endsection

@section('footer')
@include('partials.footer')
@endsection

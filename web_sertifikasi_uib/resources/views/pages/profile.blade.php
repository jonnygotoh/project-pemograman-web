@extends('templates.main')
@section('title', 'Profile')

@section('content')
<section class="profile-page">
    <div class="profile-card">
        <div class="avatar-box"><img src="{{ asset('images/avatar.png') }}" alt="Avatar"></div>

        {{-- TAMPILAN BIODATA DENGAN LOOPING @FOREACH YANG SUDAH TERBAGI 2 KOLOM --}}
        <div class="profile-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; width: 100%;">
            
            {{-- chunk(3) membagi 6 data menjadi 2 kolom (masing-masing 3 data) --}}
            @foreach(collect($profile)->chunk(3) as $column)
                <div class="info-column" style="display: flex; flex-direction: column; gap: 15px;">
                    
                    {{-- Looping isi data di dalam kolom --}}
                    @foreach($column as $item)
                        <div class="profile-row">
                            <i data-lucide="{{ $item['icon'] }}"></i>
                            <b>{{ $item['label'] }}</b>
                            <span>:</span>
                            <p>{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                    
                </div>
            @endforeach

        </div>
    </div>

    <div class="registered-card">
        <div class="section-title">
            <div><i data-lucide="menu"></i></div>
            <span><h2>Daftar</h2><p>Data Seminar & Sertifikasi</p></span>
        </div>

        {{-- TABS YANG SUDAH TERHUBUNG KE JAVASCRIPT --}}
        <div class="tabs">
            <button class="active" onclick="switchProfileTab('seminar')">Data Seminar</button>
            <button onclick="switchProfileTab('sertifikasi')">Data Sertifikasi</button>
        </div>

        <div class="table-control">
            <label>Show <select><option>10</option></select> entries</label>
            <div class="search-box"><i data-lucide="search"></i><input placeholder="Search data..."></div>
        </div>

        {{-- PANEL 1: TABEL SEMINAR --}}
        <div id="profile-seminar-panel" class="responsive-table">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Seminar</th><th>Tanggal</th><th>Status</th><th>Sertifikat</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($registered ?? [] as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><b>{{ $item['name'] ?? '-' }}</b></td>
                        <td>{{ $item['payment'] ?? '-' }}</td>
                        <td>{{ $item['note'] ?? '-' }}</td>
                        <td>{!! $item['certificate'] ?? '-' !!}</td>
                        <td>{!! $item['action'] ?? '-' !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data seminar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PANEL 2: TABEL SERTIFIKASI (Disembunyikan dengan class 'hidden' di awal) --}}
        <div id="profile-sertifikasi-panel" class="responsive-table hidden">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Sertifikasi</th><th>Tanggal</th><th>Skor</th><th>Status</th><th>Catatan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    {{-- Nanti datanya bisa diganti dengan variabel dari Controller, misal: $registeredSertifikasi --}}
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data sertifikasi.</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>
@endsection
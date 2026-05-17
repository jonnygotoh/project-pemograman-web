@extends('templates.main')
@section('title', 'Profile')

@section('content')
<section class="profile-page">
    <div class="profile-card">
        <div class="avatar-box"><img src="{{ asset('images/avatar-placeholder.png') }}" alt="Avatar"></div>

        <div class="profile-info">
            @foreach($profile as $item)
                <div class="profile-row">
                    <i data-lucide="{{ $item['icon'] }}"></i>
                    <b>{{ $item['label'] }}</b>
                    <span>:</span>
                    <p>{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="registered-card">
        <div class="section-title">
            <div><i data-lucide="menu"></i></div>
            <span><h2>Daftar</h2><p>Data Seminar & Sertifikasi</p></span>
        </div>

        <div class="tabs">
            <button class="active">Data Seminar</button>
            <button>Data Sertifikasi</button>
        </div>

        <div class="table-control">
            <label>Show <select><option>10</option></select> entries</label>
            <div class="search-box"><i data-lucide="search"></i><input placeholder="Search data..."></div>
        </div>

        <div class="responsive-table">
            <table>
                <thead>
                    <tr><th>No</th><th>Nama Seminar</th><th>Status Pembayaran</th><th>Keterangan</th><th>Sertifikat</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($registered as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><b>{{ $item['name'] }}</b></td>
                        <td>{{ $item['payment'] ?? '-' }}</td>
                        <td>{{ $item['note'] ?? '-' }}</td>
                        <td>{!! $item['certificate'] !!}</td>
                        <td>{!! $item['action'] !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

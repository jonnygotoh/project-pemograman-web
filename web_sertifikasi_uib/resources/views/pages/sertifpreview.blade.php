<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Sertifikat - Admin Verification</title>
    <link rel="stylesheet" href="{{ asset('css/sertifpreview.css') }}">
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Preview Sertifikat Peserta Seminar</h1>
        <p>Verifikasi dan konfirmasi sertifikat sebelum dipublikasikan kepada peserta</p>
    </div>

    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <strong>Nama Peserta</strong>
                <span>{{ $nama }}</span>
            </div>
            <div class="info-item">
                <strong>NPM/ID Peserta</strong>
                <span>{{ $npm }}</span>
            </div>
            <div class="info-item">
                <strong>Nomor Sertifikat</strong>
                <span>{{ $no_sertifikat }}</span>
            </div>
            <div class="info-item">
                <strong>Peran</strong>
                <span>{{ $peran }}</span>
            </div>
            <div class="info-item">
                <strong>Kegiatan</strong>
                <span>{{ $kegiatan }}</span>
            </div>
            <div class="info-item">
                <strong>Tanggal Terbit</strong>
                <span>{{ $tanggal_terbit }}</span>
            </div>
        </div>
    </div>

    <div class="confirmation-notice">
        <strong>⚠️ Perhatian:</strong>
        Setelah Anda mengklik tombol "Konfirmasi & Simpan", data sertifikat akan disimpan ke database dan dapat diakses oleh peserta dari halaman profilnya.
    </div>

    <div class="certificate-container">
        <div class="cert-text text-no">{{ $no_sertifikat }}</div>
        <div class="cert-text text-nama">{{ $nama }}</div>
        <div class="cert-text text-npm">{{ $npm }}</div>
        <div class="cert-text text-peran">{{ $peran }}</div>
        <div class="cert-text text-kegiatan">{{ $kegiatan }}</div>
        <div class="cert-text text-tanggal">{{ $tanggal_terbit }}</div>
    </div>

    @if(request()->is('admin*'))
    <div class="actions">
        <form action="{{ route('admin.sertif.confirm', ['pendaftaran_id' => $pendaftaran_id]) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-confirm">✓ Konfirmasi & Simpan</button>
        </form>
        <a href="{{ route('admin.sertif.edit', ['pendaftaran_id' => $pendaftaran_id]) }}" class="btn btn-edit">✎ Edit Data</a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">✕ Batal</a>
    </div>
    
    @endif
</div>
    @if(!request()->is('admin*'))
    <div class="actions">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak/Simpan PDF</button>
        <a href="{{ route('profile') }}" class="btn btn-back">← Kembali ke Profil</a>
    </div>
    @endif
</body>
</html>

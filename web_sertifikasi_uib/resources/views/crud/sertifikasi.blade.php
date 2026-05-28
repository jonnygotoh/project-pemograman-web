@extends('templates.main')
@section('title', 'Tambah Sertifikasi')

@section('content')
<div style="margin-top: 100px; padding: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <h2>Tambah Sertifikasi Baru</h2>
    <form action="{{ url('admin/sertifikasi/store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Nama Sertifikasi</label>
            <input type="text" name="nama" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Batch</label>
            <input type="text" name="batch" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Periode</label>
            <input type="text" name="periode" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Waktu (Tanggal)</label>
            <input type="date" name="waktu" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Biaya Mahasiswa</label>
            <input type="number" name="biaya_mahasiswa" value="0" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Biaya Dosen</label>
            <input type="number" name="biaya_dosen" value="0" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Biaya Umum</label>
            <input type="number" name="biaya_umum" value="0" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        
        <button type="submit" style="padding:10px 20px; background:#2563eb; color:#fff; border:none; cursor:pointer;">Simpan Sertifikasi</button>
        <a href="{{ route('admin.dashboard') }}" style="margin-left:15px; color:#666;">Batal</a>
    </form>
</div>
@endsection
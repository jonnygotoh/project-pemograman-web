@extends('templates.main')
@section('title', 'Tambah Seminar')

@section('content')
<div style="margin-top: 100px; padding: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <h2>Tambah Seminar Baru</h2>
    <form action="{{ url('admin/seminar/store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Nama Seminar</label>
            <input type="text" name="nama" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Periode</label>
            <input type="text" name="periode" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Waktu</label>
            <input type="text" name="waktu" placeholder="Contoh: 09:00 - 12:00" required style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Tipe</label>
            <select name="tipe" style="width:100%; padding:8px; border:1px solid #ccc;">
                <option value="free">Free</option>
                <option value="paid">Paid</option>
            </select>
        </div>
        <button type="submit" style="padding:10px 20px; background:#2563eb; color:#fff; border:none; cursor:pointer;">Simpan Data</button>
        <a href="{{ route('admin.dashboard') }}" style="margin-left:15px; color:#666;">Batal</a>
    </form>
</div>
@endsection
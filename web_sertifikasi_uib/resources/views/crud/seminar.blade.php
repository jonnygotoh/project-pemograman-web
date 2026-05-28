@extends('templates.main')
@section('title', 'Tambah Seminar')

@section('content')
<section class="admin-form-page">
    <div class="section-heading">
        <span>Form Seminar</span>
        <h2>Tambah Seminar Baru</h2>
        <p>Isi detail event seminar agar dapat ditampilkan secara rapi pada kalender admin.</p>
    </div>

    <div class="admin-form-card">
        <form action="{{ url('admin/seminar/store') }}" method="POST">
            @csrf
            <div class="admin-form-grid">
                <div class="form-group">
                    <label>
                        Nama Seminar
                        <input type="text" name="nama" required class="form-control" placeholder="Masukkan nama seminar">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Periode
                        <input type="text" name="periode" required class="form-control" placeholder="Contoh: Semester Ganjil 2026">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Tanggal
                        <input type="date" name="tanggal" required class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Waktu
                        <input type="text" name="waktu" placeholder="Contoh: 09:00 - 12:00" required class="form-control">
                    </label>
                </div>
                <div class="form-group full">
                    <label>
                        Tipe Seminar
                        <select name="tipe" class="form-control">
                            <option value="free">Free</option>
                            <option value="paid">Paid</option>
                        </select>
                        <small>Pilih jenis seminar untuk kebutuhan peserta.</small>
                    </label>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-primary">Simpan Data</button>
                <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-outline-danger">Batal</a>
            </div>
        </form>
    </div>
</section>
@endsection
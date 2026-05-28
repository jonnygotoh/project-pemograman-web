@extends('templates.main')
@section('title', 'Tambah Sertifikasi')

@section('content')
<section class="admin-form-page">
    <div class="section-heading">
        <span>Form Sertifikasi</span>
        <h2>Tambah Sertifikasi Baru</h2>
        <p>Isi detail sertifikasi agar peserta dapat melihat biaya dan tanggal pelaksanaan secara jelas.</p>
    </div>

    <div class="admin-form-card">
        <form action="{{ url('admin/sertifikasi/store') }}" method="POST">
            @csrf
            <div class="admin-form-grid">
                <div class="form-group">
                    <label>
                        Nama Sertifikasi
                        <input type="text" name="nama" required class="form-control" placeholder="Masukkan nama sertifikasi">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Batch
                        <input type="text" name="batch" required class="form-control" placeholder="Contoh: Batch 4">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Periode
                        <input type="text" name="periode" required class="form-control" placeholder="Contoh: Semester Genap 2026">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Tanggal Sertifikasi
                        <input type="date" name="waktu" required class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Biaya Mahasiswa
                        <input type="number" name="biaya_mahasiswa" value="0" required class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Biaya Dosen
                        <input type="number" name="biaya_dosen" value="0" required class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        Biaya Umum
                        <input type="number" name="biaya_umum" value="0" required class="form-control">
                    </label>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-primary">Simpan Sertifikasi</button>
                <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-outline-danger">Batal</a>
            </div>
        </form>
    </div>
</section>
@endsection
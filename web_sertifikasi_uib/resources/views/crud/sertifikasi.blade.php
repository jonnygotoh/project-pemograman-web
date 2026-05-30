@extends('templates.main')
@section('title', isset($item) ? 'Edit Sertifikasi' : 'Tambah Sertifikasi')

@section('content')
<section class="admin-form-page">
    <h2>{{ isset($item) ? 'Edit Sertifikasi' : 'Tambah Sertifikasi Baru' }}</h2>

    <form action="{{ isset($item) ? route('admin.sertifikasi.update', $item->id) : route('admin.sertifikasi.store') }}" method="POST">
        @csrf
        @if(isset($item)) @method('PUT') @endif
        
        <div class="admin-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Nama Sertifikasi 
                    <input type="text" name="nama" value="{{ $item->nama ?? '' }}" required class="form-control" placeholder="Nama Sertifikasi">
                </label>
            </div>
            <div class="form-group">
                <label>Batch 
                    <input type="text" name="batch" value="{{ $item->batch ?? '' }}" required class="form-control" placeholder="Contoh: Batch 4">
                </label>
            </div>
            <div class="form-group">
                <label>Periode 
                    <input type="text" name="periode" value="{{ $item->periode ?? '' }}" required class="form-control" placeholder="Semester Genap 2026">
                </label>
            </div>
            <div class="form-group">
                <label>Tanggal Sertifikasi 
                    <input type="date" name="waktu" value="{{ isset($item) ? \Carbon\Carbon::parse($item->waktu)->format('Y-m-d') : '' }}" required class="form-control">
                </label>
            </div>
            
            <div class="form-group">
                <label>Biaya Mahasiswa (Rp) 
                    <input type="number" name="biaya_mahasiswa" value="{{ $item->biaya_mahasiswa ?? 0 }}" required class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label>Biaya Dosen (Rp) 
                    <input type="number" name="biaya_dosen" value="{{ $item->biaya_dosen ?? 0 }}" required class="form-control">
                </label>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Biaya Umum (Rp) 
                    <input type="number" name="biaya_umum" value="{{ $item->biaya_umum ?? 0 }}" required class="form-control">
                </label>
            </div>
        </div> 

        <div class="Adash" style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px; width: 100%;">
            <button type="submit" class="btn-primary" style="width: 100%;">Simpan Data</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary" style="text-align: center; text-decoration: none; width: 100%; padding: 10px; background: #666;">Batal</a>
        </div>    
    </form>
</section>
@endsection
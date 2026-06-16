@extends('templates.main')
@section('title', isset($item) ? 'Edit Sertifikasi' : 'Tambah Sertifikasi')

@section('content')
<section class="admin-form-page">
    <h2>{{ isset($item) ? 'Edit Sertifikasi' : 'Tambah Sertifikasi Baru' }}</h2>

    <form id="sertifikasi-form"
          action="{{ isset($item) ? route('admin.sertifikasi.update', $item->id) : route('admin.sertifikasi.store') }}"
          method="POST">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif
        
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
                <label>Jam
                    <input type="text" name="jam" value="{{ $item->jam ?? '' }}" required class="form-control">
                </label>
            </div>

            <div class="form-group">
                <label>Tempat
                    <input type="text" name="tempat" value="{{ $item->tempat ?? '' }}" required class="form-control">
                </label>
            </div>

            <div class="form-group">
                <label>Biaya Mahasiswa (Rp)
                    <input type="number" name="biaya_mahasiswa" value="{{ $item->biaya_mahasiswa ?? 0 }}" required class="form-control" max="10000000" min="0">
                </label>
            </div>

            <div class="form-group">
                <label>Biaya Dosen (Rp)
                    <input type="number" name="biaya_dosen" value="{{ $item->biaya_dosen ?? 0 }}" required class="form-control" max="10000000" min="0">
                </label>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Biaya Umum (Rp)
                    <input type="number" name="biaya_umum" value="{{ $item->biaya_umum ?? 0 }}" required class="form-control" max="10000000" min="0">
                </label>
            </div>
        </div>

        <div class="Adash" style="display: flex; flex-direction: row; gap: 10px; margin-top: 20px; width: 100%; justify-content: space-between;">
            <div style="display: flex; gap: 10px; flex: 1;">
                <button type="button"
                        class="btn-primary"
                        style="flex: 1; background: #007bff; color: white;"
                        onclick="confirmAddRemove({
                            formId:'sertifikasi-form',
                            text:'Apakah anda yakin ingin menyimpan data sertifikasi ini?',
                            confirmText:'Simpan'
                        })">
                    Simpan Data
                </button>

                @if(isset($item))
                    <button type="button"
                            class="btn-primary"
                            style="flex: 0.7; background: #d33; color: white;"
                            onclick="confirmAddRemove({
                                formId:'delete-seminar-form',
                                text:'Apakah anda yakin ingin menghapus sertifikasi ini?',
                                confirmText:'Hapus',
                                icon:'warning',
                                confirmColor:'#d33'
                            })">
                        Hapus
                    </button>
                @endif
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="btn-primary"
               style="text-align: center; text-decoration: none; padding: 10px 20px; background: #666; color: white; border-radius: 4px; align-self: center;">
                Batal
            </a>
        </div>
    </form>

    @if(isset($item))
        <form id="delete-seminar-form"
              action="{{ route('admin.sertifikasi.delete', $item->id) }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</section>
@endsection
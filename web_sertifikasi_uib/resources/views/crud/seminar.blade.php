@extends('templates.main')
@section('title', isset($item) ? 'Edit Seminar' : 'Tambah Seminar')

@section('content')
<section class="admin-form-page">
    <h2>{{ isset($item) ? 'Edit Seminar' : 'Tambah Seminar Baru' }}</h2>

    <form id="seminar-form"
          action="{{ isset($item) ? route('admin.seminar.update', $item->id) : route('admin.seminar.store') }}"
          method="POST">
        @csrf
        @if(isset($item)) @method('PUT') @endif
        
        <div class="admin-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Nama 
                    <input type="text" name="nama" value="{{ $item->nama ?? '' }}" required class="form-control">
                </label>
            </div>
            
            <div class="form-group">
                <label>Periode 
                    <input type="text" name="periode" value="{{ $item->periode ?? '' }}" required class="form-control">
                </label>
            </div>
            
            <div class="form-group">
                <label>Tanggal 
                    <input type="date" name="tanggal" value="{{ isset($item) ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '' }}" required class="form-control">
                </label>
            </div>
            
            <div class="form-group">
                <label>Waktu 
                    <input type="text" name="waktu" value="{{ $item->waktu ?? '' }}" required class="form-control" placeholder="Contoh: 09:00 - 12:00">
                </label>
            </div>

            <div class="form-group">
                <label>Tempat 
                    <input type="text" name="tempat" value="{{ $item->tempat ?? '' }}" required class="form-control">
                </label>
            </div>

            <div class="form-group">
                <label>Token Event (Kode Akses)
                    <input type="text" name="token_event" value="{{ $item->token_event ?? '' }}" 
                        class="form-control" placeholder="Contoh: SEMINAR2026-XYZ" required>
                </label>
            </div>
            
        </div>

        <div class="Adash" style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px; width: 100%; max-width: 300px;">
            <button type="button"
                    class="btn-primary"
                    style="width: 100%; background: #007bff; color: white; padding: 10px; border-radius: 4px; border: none; font-weight: 600; cursor: pointer;"
                    onclick="confirmAddRemove({
                        formId:'seminar-form',
                        text:'Apakah anda yakin ingin menyimpan data seminar ini?',
                        confirmText:'Simpan'
                    })">
                Simpan
            </button>

            @if(isset($item))
                <button type="button"
                        class="btn-primary"
                        style="width: 100%; background: #d33; color: white; padding: 10px; border-radius: 4px; border: none; font-weight: 600; cursor: pointer;"
                        onclick="confirmAddRemove({
                            formId:'delete-seminar-form',
                            text:'Apakah anda yakin ingin menghapus seminar ini?',
                            confirmText:'Hapus',
                            icon:'warning',
                            confirmColor:'#d33'
                        })">
                    Hapus
                </button>
            @endif

            <a href="{{ route('admin.dashboard') }}"
               class="btn-primary"
               style="text-align: center; text-decoration: none; padding: 10px; background: #666; color: white; border-radius: 4px; font-weight: 600;">
                Batal
            </a>
        </div>
    </form>

    @if(isset($item))
        <form id="delete-seminar-form"
              action="{{ route('admin.seminar.delete', $item->id) }}"
              method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</section>
@endsection
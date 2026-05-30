@extends('templates.main')
@section('title', isset($item) ? 'Edit Seminar' : 'Tambah Seminar')

@section('content')
<section class="admin-form-page">
    <h2>{{ isset($item) ? 'Edit Seminar' : 'Tambah Seminar Baru' }}</h2>

    <form action="{{ isset($item) ? route('admin.seminar.update', $item->id) : route('admin.seminar.store') }}" method="POST">
        @csrf
        
        <div class="admin-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group"><label>Nama <input type="text" name="nama" value="{{ $item->nama ?? '' }}" required class="form-control"></label></div>
            <div class="form-group"><label>Periode <input type="text" name="periode" value="{{ $item->periode ?? '' }}" required class="form-control"></label></div>
            <div class="form-group"><label>Tanggal <input type="date" name="tanggal" value="{{ isset($item) ? $item->tanggal->format('Y-m-d') : '' }}" required class="form-control"></label></div>
            <div class="form-group"><label>Waktu <input type="text" name="waktu" value="{{ $item->waktu ?? '' }}" required class="form-control"></label></div>
            
            <div class="form-group">
                <label>Tipe
                    <select name="tipe" id="tipe-select" class="form-control" onchange="toggleBiaya(this.value)">
                        <option value="free" {{ ($item->tipe ?? '') == 'free' ? 'selected' : '' }}>Free</option>
                        <option value="paid" {{ ($item->tipe ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </label>
            </div>

            <div class="form-group" id="biaya-group" style="grid-column: span 2; {{ ($item->tipe ?? '') == 'paid' ? 'display: block;' : 'display: none;' }}">
                <label>Biaya (Rp) <input type="number" name="biaya" value="{{ $item->biaya ?? 0 }}" class="form-control"></label>
            </div>
        </div> 

        <div class="Adash" style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px; width: 100%;">
            <button type="submit" class="btn-primary" style="width: 100%;">Simpan Data</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary" style="text-align: center; text-decoration: none; width: 100%; padding: 10px;">Batal</a>
        </div>    
    </form>
</section>

<script>
    function toggleBiaya(value) {
        document.getElementById('biaya-group').style.display = (value === 'paid') ? 'block' : 'none';
    }
</script>
@endsection
@extends('templates.main')
@section('title', 'Upload Bukti Transfer')

@section('content')
<section class="upload-page">
    <form class="upload-card" method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="sertifikasi_id" value="{{ $sertifikasi_id }}">

        <h1>Upload Bukti Transfer</h1>
        <div class="title-line"></div>

        <section class="form-section">
            <h3><i data-lucide="receipt-text"></i> Informasi Pembayaran</h3>
            
            <label>Bukti Bayar
                <input name="bukti_bayar" type="file" required accept=".jpg,.jpeg,.png">
            </label>
            <small>Maks. ukuran file 2 MB (jpeg, jpg, png)</small>
            
            <label>Keterangan Tambahan
                <textarea name="note" placeholder="Tulis catatan jika ada..."></textarea>
            </label>
        </section>

        <div class="upload-actions">
            <button class="btn-dark" type="submit"><i data-lucide="upload"></i> Upload</button>
            <a class="btn-outline-danger" href="{{ url()->previous() }}"><i data-lucide="arrow-left"></i> Kembali</a>
        </div>
    </form>
</section>
@endsection
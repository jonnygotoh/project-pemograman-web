@extends('layouts.app')
@section('title', 'Upload Bukti Transfer')

@section('content')
<section class="upload-page">
    <form class="upload-card" method="POST" action="#" enctype="multipart/form-data">
        @csrf
        <h1>Upload Bukti Transfer</h1>
        <div class="title-line"></div>

        <div class="upload-grid">
            <section class="form-section">
                <h3><i data-lucide="receipt-text"></i> Informasi Pembayaran</h3>
                <div class="form-grid-2">
                    <label>Nama Bank<input name="bank_name" placeholder="Masukkan nama bank"></label>
                    <label>Nama Pemilik<input name="owner_name" placeholder="Masukkan nama pemilik rekening"></label>
                    <label>No. Rekening<input name="account_number" placeholder="Masukkan nomor rekening"></label>
                    <label>Tanggal Pembayaran<input name="payment_date" type="date"></label>
                </div>
                <label>Bukti Bayar<input name="payment_file" type="file"></label>
                <small>Maks. ukuran file 200 KB (jpeg, jpg)</small>
                <label>No. Telp / No Whatsapp yang bisa dihubungi<input name="phone" placeholder="Masukkan nomor telepon / whatsapp"></label>
                <label>Keterangan Pembayaran<textarea name="note" placeholder="Mohon mengisi keterangan pendaftaran atau isi dengan -"></textarea></label>
            </section>

            <section class="form-section">
                <h3><i data-lucide="id-card"></i> Informasi Tambahan TOEIC / TOEFL</h3>
                <label>Tipe Identitas<select name="identity_type"><option>Pilih salah satu</option><option>KTP</option><option>KTM</option><option>Passport</option></select></label>
                <label>Nomor Identitas<input name="identity_number" placeholder="Masukkan nomor identitas"></label>
                <label>Kartu Identitas<input name="identity_file" type="file"></label>
                <div class="form-grid-2">
                    <label>Tempat Lahir<input name="birth_place" placeholder="Masukkan tempat lahir"></label>
                    <label>Tanggal Lahir<input name="birth_date" type="date"></label>
                </div>
                <label>Pas Photo<input name="photo" type="file"></label>
            </section>
        </div>

        <div class="upload-actions">
            <button class="btn-dark" type="submit"><i data-lucide="upload"></i> Upload</button>
            <a class="btn-outline-danger" href="{{ url()->previous() }}"><i data-lucide="arrow-left"></i> Kembali</a>
        </div>
    </form>
</section>
@endsection

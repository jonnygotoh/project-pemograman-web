<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sertifikat Seminar - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/sertifmaker.css') }}">
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Edit & Buat Sertifikat Seminar</h1>
        <p>Isi data sertifikat untuk peserta seminar</p>
    </div>

    <div class="content-wrapper">
        <!-- Form Section -->
        <div class="form-section">
            <h2>Data Peserta & Sertifikat</h2>

            <!-- Info Peserta -->
            <div class="info-box">
                <div class="info-row">
                    <strong>Nama:</strong>
                    <span>{{ $nama }}</span>
                </div>
                <div class="info-row">
                    <strong>NPM:</strong>
                    <span>{{ $npm }}</span>
                </div>
                <div class="info-row">
                    <strong>Seminar:</strong>
                    <span>{{ $seminar_nama }}</span>
                </div>
                <div class="info-row">
                    <strong>Tanggal Seminar:</strong>
                    <span>{{ \Carbon\Carbon::parse($tanggal_seminar)->format('d/m/Y') }}</span>
                </div>
            </div>

            <form action="{{ route('admin.sertif.store', ['pendaftaran_id' => $pendaftaran_id]) }}" method="POST" id="sertifForm">
                @csrf

                <div class="form-group">
                    <label for="no_sertifikat">No. Sertifikat</label>
                    <input 
                        type="text" 
                        id="no_sertifikat" 
                        name="no_sertifikat" 
                        value="{{ $no_sertifikat }}"
                        placeholder="Contoh: SERTIF/2026/001"
                        required
                        oninput="updatePreview()"
                    >
                </div>

                <div class="form-group">
                    <label for="peran">Peran</label>
                    <input 
                        type="text" 
                        id="peran" 
                        name="peran" 
                        value="{{ $peran }}"
                        placeholder="PESERTA"
                        required
                        oninput="updatePreview()"
                    >
                </div>

                <div class="form-group">
                    <label for="kegiatan">Kegiatan</label>
                    <textarea 
                        id="kegiatan" 
                        name="kegiatan" 
                        placeholder="Deskripsi kegiatan seminar"
                        required
                        oninput="updatePreview()"
                    >{{ $kegiatan }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal_terbit">Tanggal Terbit</label>
                    <input 
                        type="text" 
                        id="tanggal_terbit" 
                        name="tanggal_terbit" 
                        value="{{ $tanggal_terbit }}"
                        placeholder="dd/mm/yyyy atau 29/06/2026"
                        required
                        oninput="updatePreview()"
                    >
                    <small style="color:#666; margin-top:5px; display:block;">Format: dd/mm/yyyy atau 'Kota, dd Bulan Tahun'</small>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Lanjut ke Preview</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="text-decoration:none; display:flex; align-items:center; justify-content:center;">Kembali</a>
                </div>

                <div class="notes">
                    <strong>💡 Tips:</strong>
                    <ul style="margin-left:20px; margin-top:5px;">
                        <li>Nomor sertifikat harus unik untuk setiap peserta</li>
                        <li>Kolom "Kegiatan" berisi nama/deskripsi event yang diikuti</li>
                        <li>Format tanggal: Kota, dd Bulan Tahun (contoh: 29/06/2026)</li>
                        <li>Data dapat diubah kapan saja sebelum dikonfirmasi</li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="preview-section">
            <h2>Preview Sertifikat</h2>

            <div class="certificate-preview">
                <div class="preview-text preview-no" id="previewNo">{{ $no_sertifikat }}</div>
                <div class="preview-text preview-nama" id="previewNama">{{ $nama }}</div>
                <div class="preview-text preview-npm" id="previewNpm">{{ $npm }}</div>
                <div class="preview-text preview-peran" id="previewPeran">{{ $peran }}</div>
                <div class="preview-text preview-kegiatan" id="previewKegiatan">{{ $kegiatan }}</div>
                <div class="preview-text preview-tanggal" id="previewTanggal">{{ $tanggal_terbit }}</div>
            </div>

            <div style="background:#f0f4f8; padding:15px; border-radius:6px; font-size:13px; color:#666;">
                <strong>Preview akan update secara real-time</strong> saat Anda mengisi form di sebelah kiri.
            </div>
        </div>
    </div>
</div>

<script>
function updatePreview() {
    const no = document.getElementById('no_sertifikat').value;
    const peran = document.getElementById('peran').value;
    const kegiatan = document.getElementById('kegiatan').value;
    const tanggal = document.getElementById('tanggal_terbit').value;

    document.getElementById('previewNo').textContent = no || 'NOMOR SERTIFIKAT';
    document.getElementById('previewPeran').textContent = peran || 'PERAN';
    document.getElementById('previewKegiatan').textContent = kegiatan || 'DESKRIPSI KEGIATAN';
    document.getElementById('previewTanggal').textContent = tanggal || 'TANGGAL TERBIT';
}

// Update preview on page load
document.addEventListener('DOMContentLoaded', updatePreview);
</script>

</body>
</html>

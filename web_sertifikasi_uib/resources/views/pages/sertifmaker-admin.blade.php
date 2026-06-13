<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sertifikat Seminar - Admin</title>

    <style>
        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        body{
            font-family:Arial,sans-serif;
            background-color:#eef2f5;
            padding:50px 20px;
        }

        .container{
            max-width:1200px;
            margin:0 auto;
        }

        .header{
            text-align:center;
            margin-bottom:30px;
        }

        .header h1{
            color:#123e75;
            margin-bottom:10px;
        }

        .header p{
            color:#666;
            font-size:14px;
        }

        .content-wrapper{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;
            align-items:start;
        }

        .form-section{
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .form-section h2{
            color:#123e75;
            margin-bottom:20px;
            font-size:18px;
            border-bottom:2px solid #123e75;
            padding-bottom:10px;
        }

        .info-box{
            background:#f0f4f8;
            padding:15px;
            border-radius:6px;
            margin-bottom:20px;
            border-left:4px solid #123e75;
        }

        .info-row{
            display:flex;
            margin-bottom:10px;
            font-size:14px;
        }

        .info-row strong{
            min-width:120px;
            color:#123e75;
        }

        .info-row span{
            color:#666;
            word-break:break-word;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;
            margin-bottom:8px;
            color:#333;
            font-weight:bold;
            font-size:14px;
        }

        .form-group input,
        .form-group textarea{
            width:100%;
            padding:10px;
            border:1px solid #ddd;
            border-radius:6px;
            font-family:Arial,sans-serif;
            font-size:14px;
            transition:border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus{
            outline:none;
            border-color:#123e75;
            box-shadow:0 0 5px rgba(18,62,117,0.2);
        }

        .form-group textarea{
            min-height:80px;
            resize:vertical;
        }

        .button-group{
            display:flex;
            gap:10px;
            margin-top:30px;
        }

        .btn{
            flex:1;
            padding:12px 20px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
            font-size:14px;
            transition:all 0.3s ease;
        }

        .btn-primary{
            background-color:#123e75;
            color:white;
        }

        .btn-primary:hover{
            background-color:#0a264a;
            transform:translateY(-2px);
            box-shadow:0 4px 12px rgba(18,62,117,0.3);
        }

        .btn-secondary{
            background-color:#6c757d;
            color:white;
        }

        .btn-secondary:hover{
            background-color:#5a6268;
        }

        .preview-section{
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .preview-section h2{
            color:#123e75;
            margin-bottom:20px;
            font-size:18px;
            border-bottom:2px solid #123e75;
            padding-bottom:10px;
        }

        .certificate-preview{
            position:relative;
            width:100%;
            aspect-ratio:1.414/1;
            background-image:url('{{ asset('images/templatesertif.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            border:2px solid #ddd;
            border-radius:6px;
            overflow:hidden;
            margin-bottom:20px;
        }

        .preview-text{
            position:absolute;
            left:50%;
            transform:translateX(-50%);
            text-align:center;
            color:#000;
            font-weight:bold;
        }

        .preview-no{
            top:22%;
            width:80%;
            font-size:12px;
            font-family:'Times New Roman', serif;
        }

        .preview-nama{
            top:30%;
            width:85%;
            font-size:20px;
            font-weight:bold;
            font-family:'Arial Black', Impact, sans-serif;
        }

        .preview-npm{
            top:38%;
            width:70%;
            font-size:11px;
            font-style:italic;
        }

        .preview-peran{
            top:44%;
            width:75%;
            font-size:14px;
        }

        .preview-kegiatan{
            top:52%;
            width:85%;
            font-size:11px;
        }

        .preview-tanggal{
            top:58%;
            width:75%;
            font-size:10px;
        }

        .notes{
            background:#fff3cd;
            border:1px solid #ffc107;
            border-radius:6px;
            padding:15px;
            margin-top:20px;
            font-size:13px;
            color:#856404;
        }

        .notes strong{
            display:block;
            margin-bottom:5px;
        }

        @media (max-width: 768px) {
            .content-wrapper{
                grid-template-columns:1fr;
            }

            .preview-section{
                order:-1;
            }
        }
    </style>
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
                    <span>{{ \Carbon\Carbon::parse($tanggal_seminar)->format('d F Y') }}</span>
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
                        <li>Format tanggal: Kota, dd Bulan Tahun (contoh: Batam, 29 Mei 2026)</li>
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

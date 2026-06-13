<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Seminar</title>

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
            max-width:1000px;
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

        .certificate-container{
            position:relative;
            width:100%;
            aspect-ratio:1.414/1;
            background-image:url('{{ asset('images/templatesertif.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
            margin-bottom:30px;
            border-radius:8px;
            overflow:hidden;
        }

        .cert-text{
            position:absolute;
            left:50%;
            transform:translateX(-50%);
            text-align:center;
            color:#000;
        }

        .text-no{
            top:22%;
            width:80%;
            font-size:12px;
            font-family:'Times New Roman', serif;
        }

        .text-nama{
            top:30%;
            width:85%;
            font-size:20px;
            font-weight:bold;
            font-family:'Arial Black', Impact, sans-serif;
        }

        .text-npm{
            top:38%;
            width:70%;
            font-size:11px;
            font-style:italic;
        }

        .text-peran{
            top:44%;
            width:75%;
            font-size:14px;
        }

        .text-kegiatan{
            top:52%;
            width:85%;
            font-size:11px;
        }

        .text-tanggal{
            top:58%;
            width:75%;
            font-size:10px;
        }

        .actions{
            display:flex;
            gap:15px;
            justify-content:center;
            flex-wrap:wrap;
            margin-bottom:30px;
        }

        .btn{
            padding:12px 30px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
            font-size:14px;
            transition:all 0.3s ease;
            text-decoration:none;
            display:inline-block;
        }

        .btn-download{
            background-color:#28a745;
            color:white;
        }

        .btn-download:hover{
            background-color:#218838;
            transform:translateY(-2px);
            box-shadow:0 4px 12px rgba(40,167,69,0.3);
        }

        .btn-print{
            background-color:#007bff;
            color:white;
        }

        .btn-print:hover{
            background-color:#0056b3;
            transform:translateY(-2px);
            box-shadow:0 4px 12px rgba(0,86,179,0.3);
        }

        .btn-back{
            background-color:#6c757d;
            color:white;
        }

        .btn-back:hover{
            background-color:#5a6268;
        }

        .info-box{
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            margin-bottom:20px;
        }

        .info-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
            gap:15px;
        }

        .info-item{
            padding:15px;
            background:#f0f4f8;
            border-radius:6px;
            border-left:4px solid #123e75;
        }

        .info-item strong{
            display:block;
            color:#123e75;
            margin-bottom:5px;
            font-size:12px;
        }

        .info-item span{
            color:#333;
            font-size:14px;
            word-break:break-word;
        }

        .success-message{
            background:#d4edda;
            border:1px solid #c3e6cb;
            color:#155724;
            padding:15px;
            border-radius:6px;
            margin-bottom:20px;
        }

        .success-message strong{
            display:block;
            margin-bottom:5px;
        }

        @media print {
            body{
                padding:0;
                background:white;
            }

            .container{
                margin:0;
            }

            .header, .actions, .info-box{
                display:none;
            }

            .certificate-container{
                box-shadow:none;
                margin-bottom:0;
                aspect-ratio:210/297mm;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Sertifikat Seminar Anda</h1>
        <p>Selamat! Anda telah menyelesaikan kegiatan seminar</p>
    </div>

    <div class="success-message">
        <strong>✓ Sertifikat Terverifikasi</strong>
        Sertifikat ini telah diverifikasi oleh admin dan siap untuk diunduh atau dicetak.
    </div>

    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <strong>Nama</strong>
                <span>{{ $nama }}</span>
            </div>
            <div class="info-item">
                <strong>NPM</strong>
                <span>{{ $npm }}</span>
            </div>
            <div class="info-item">
                <strong>Nomor Sertifikat</strong>
                <span>{{ $no_sertifikat }}</span>
            </div>
            <div class="info-item">
                <strong>Peran</strong>
                <span>{{ $peran }}</span>
            </div>
            <div class="info-item">
                <strong>Kegiatan</strong>
                <span>{{ $kegiatan }}</span>
            </div>
            <div class="info-item">
                <strong>Tanggal Terbit</strong>
                <span>{{ $tanggal_terbit }}</span>
            </div>
        </div>
    </div>

    <div class="certificate-container">
        <div class="cert-text text-no">{{ $no_sertifikat }}</div>
        <div class="cert-text text-nama">{{ $nama }}</div>
        <div class="cert-text text-npm">{{ $npm }}</div>
        <div class="cert-text text-peran">{{ $peran }}</div>
        <div class="cert-text text-kegiatan">{{ $kegiatan }}</div>
        <div class="cert-text text-tanggal">{{ $tanggal_terbit }}</div>
    </div>

    <div class="actions">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak/Simpan PDF</button>
        <a href="{{ route('profile') }}" class="btn btn-back">← Kembali ke Profil</a>
    </div>
</div>

</body>
</html>

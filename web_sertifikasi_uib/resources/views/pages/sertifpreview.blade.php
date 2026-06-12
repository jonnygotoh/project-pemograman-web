<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Sertifikat</title>

    <style>
        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        body{
            font-family:Arial,sans-serif;
            background-color:#eef2f5;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:50px 20px;
        }

        .certificate-container{
            position:relative;
            width:1000px;
            height:707px;
            background-image:url('{{ asset('images/templatesertif.png') }}');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
        }

.cert-text{
    position:absolute;
    left:50%;
    transform:translateX(-50%);
    text-align:center;
    color:#000;
}

.input-no{
    top:31%;
    width:400px;
    font-size:16px;
}

.input-nama{
    top:41.5%;
    width:600px;
    font-size:32px;
    font-weight:bold;
}

.input-npm{
    top:52%;
    width:250px;
    font-size:18px;
}

.input-peran{
    top:61.5%;
    width:300px;
    font-size:24px;
}

.input-kegiatan{
    top:72%;
    width:700px;
    font-size:18px;
}

.input-tanggal{
    top:79%;
    width:300px;
    font-size:16px;
}
    </style>
</head>
<body>

<div class="certificate-container">

    <div class="cert-text input-no">
        {{ $no_sertifikat }}
    </div>

    <div class="cert-text input-nama">
        {{ $nama }}
    </div>

    <div class="cert-text input-npm">
        {{ $npm }}
    </div>

    <div class="cert-text input-peran">
        {{ $peran }}
    </div>

    <div class="cert-text input-kegiatan">
        {{ $kegiatan }}
    </div>

    <div class="cert-text input-tanggal">
        {{ $tanggal }}
    </div>

</div>

</div>

</body>
</html>
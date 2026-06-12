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

        .cert-input{
            position:absolute;
            left:50%;
            transform:translateX(-50%);
            text-align:center;
            background:rgba(255,255,255,0.6);
            border:1px dashed #444;
            outline:none;
            color:#000;
            transition:all .3s ease;
        }

        .cert-input:focus{
            background:rgba(255,255,255,0.9);
            border:1px solid #0056b3;
            box-shadow:0 0 5px rgba(0,86,179,0.5);
        }

        .input-no{
            top:31%;
            width:400px;
            height:30px;
            font-size:16px;
            font-family:'Times New Roman', serif;
        }

        .input-nama{
            top:41.5%;
            width:600px;
            height:50px;
            font-size:32px;
            font-weight:bold;
            font-family:'Arial Black', Impact, sans-serif;
            letter-spacing:1px;
        }

        .input-npm{
            top:52%;
            width:250px;
            height:30px;
            font-size:18px;
            font-style:italic;
            letter-spacing:3px;
        }

        .input-peran{
            top:61.5%;
            width:300px;
            height:40px;
            font-size:24px;
            font-family:'Times New Roman', serif;
        }

        .input-kegiatan{
            top:72%;
            width:700px;
            height:35px;
            font-size:18px;
            font-family:'Times New Roman', serif;
        }

        .input-tanggal{
            top:79%;
            width:300px;
            height:30px;
            font-size:16px;
            font-family:'Times New Roman', serif;
        }

        .submit-btn{
            position:absolute;
            bottom:-70px;
            left:50%;
            transform:translateX(-50%);
            padding:15px 40px;
            font-size:18px;
            background-color:#123e75;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
        }

        .submit-btn:hover{
            background-color:#0a264a;
        }
    </style>
</head>
<body>

<div class="certificate-container">

<form action="{{ route('sertifikat.generate') }}" method="POST">
    @csrf

    <input type="text" name="nama"
           class="cert-input input-nama"
           placeholder="Nama Peserta">

    <input type="text" name="npm"
           class="cert-input input-npm"
           placeholder="NPM">

    <input type="text" name="peran"
           class="cert-input input-peran"
           placeholder="PESERTA">

    <input type="text" name="tanggal"
           class="cert-input input-tanggal"
           placeholder="Batam, 29 Mei 2026">

    <button type="submit" class="submit-btn">
         Sertifikat
    </button>
</form>

</div>

</body>
</html>
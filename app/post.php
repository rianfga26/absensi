<?php
require_once "database/mydbCon.php";
require_once "config/Quickstart.php";

date_default_timezone_set('Asia/Jakarta');
setlocale(LC_ALL, 'id_ID');

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

if (empty($params)) {
    header("Location: $actual_link");
    exit();
}


$judul = explode('-', $params);
if (count($judul) > 1) {
    $namaJudul = join(" ", $judul);
    $sql = "SELECT * FROM kegiatan WHERE nama = '" . $namaJudul . "'";
} else {
    $namaJudul = $judul[0];
    $sql = "SELECT * FROM kegiatan WHERE nama = '" . $namaJudul . "'";
}

if (isset($_COOKIE[$params])) {
    $message = "Terimakasih telah mengisi presensi kehadiran apabila terdapat kendala, silahkan hubungi panitia kegiatan. Terima Kasih";
    include('app/alert.php');
    die;
}

$hasil = mysqli_query($con, $sql);
if ($hasil->num_rows == 0) {
    header('Location: /404');
    exit();
} else {
    while ($row = $hasil->fetch_assoc()) {
        if ($row['status'] == 'close') {
            setcookie($params, "");
            $judulKegiatan = join(" ", $judul);
            $message = "Presensi kehadiran sudah di tutup, silahkan hubungi panitia kegiatan. Terima Kasih";
            include('app/alert.php');
            die;
        }
    }
}

if (isset($_POST['submit'])) {
    $folderPath = "upload/";
    $nama = $_POST['name'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];

    $date = date("d/m/Y");

    // image proses
    $image_parts = explode(";base64,", $_POST['image']);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = $folderPath . uniqid() . '.' . $image_type;

    $values = [
        ["$date", "$nama", "$nim", "$prodi", "$actual_link/$file"]
    ];


    $result = mysqli_query($con, $sql);

    // var_dump($result);die;
    if ($result) {
        setcookie($params, "true", time() + 30 * 24 * 60 * 60);
        while ($row = $result->fetch_assoc()) {
            $create_file = file_put_contents($file, $image_base64);
            create_new_data($row['spreadsheetID'], $row['nama_sheet'], $values, $service);
            header("Refresh:0");
        }
    }
}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Cyber Unusa">
    <title>Absensi UKM CYBER</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/cover/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.2/examples/cover/cover.css">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .card-body {
            box-shadow: 1px 1px 10px #888888;
        }

        .wrapper {
            width: 100%;
            background: #fff;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .wrapper .input-data {
            height: 40px;
            width: 100%;
            position: relative;
        }

        .wrapper .input-data input {
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            font-size: 17px;
            border-bottom: 2px solid silver;
            color: white;
        }

        .wrapper .input-data label {
            position: absolute;
            bottom: 10px;
            left: 0;
            color: grey;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-data input:focus~label,
        .input-data input:valid~label {
            transform: translateY(-20px);
            font-size: 15px;
            color: #4158d0;
        }

        .wrapper .input-data .underline {
            position: absolute;
            bottom: 0px;
            height: 2px;
            width: 100%;
        }

        .input-data .underline:before {
            position: absolute;
            content: "";
            height: 100%;
            width: 100%;
            background: #4158d0;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        #signature {
            width: 100%;
            height: 200px;
        }

        canvas {
            width: 100%;
            height: 100%;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
</head>

<body class="h-100 text-center text-bg-dark">

    <div class="cover-container d-flex w-100 p-3 mx-auto flex-column">

        <main class="px-3">
            <img src="https://i.postimg.cc/s2HMKN10/UKM-CYBER-LOGO-OPT.png" alt="Cyber Unusa" width="70" class="rounded-circle mb-4">
            <h1 class="mb-3">Absensi Cyber UNUSA</h1>
            <div class="card">
                <div class="card-body bg-dark rounded">
                    <form action="" method="POST">
                        <div class="wrapper bg-dark">
                            <h3 class="mb-5"><?= join(' ', $judul) ?></h3>
                            <div class="input-data mb-4">
                                <input type="text" class="bg-dark" required autocomplete="off" name="name">
                                <div class="underline"></div>
                                <label>Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="input-data mb-4">
                                <input type="number" class="bg-dark" required autocomplete="off" name="nim" maxlength="15">
                                <div class="underline"></div>
                                <label>NIM <span class="text-danger">*</span></label>
                            </div>
                            <div class="input-data mb-5">
                                <input type="text" class="bg-dark" required autocomplete="off" name="prodi">
                                <div class="underline"></div>
                                <label>Prodi (Instansi Selain UNUSA) <span class="text-danger">*</span></label>
                            </div>
                            <div class="mb-4">
                                <p>Tanda Tangan <span class="float-end" id="clear"><a href="javascript:void(0)" onclick="signaturePad.clear()" style="text-decoration: none;">Clear</a></span></p>
                                <div id="signature" class="border border-white border-2 rounded">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                            </div>
                            <input type="hidden" id='image' name="image" value="" required>
                            <button class="btn btn-success w-100" type="submit" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <footer class="mt-5 text-white-50">
            <p>Copyright &copy; Cyber UNUSA 2022</p>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.querySelector("canvas");
        const signaturePad = new SignaturePad(canvas, {
            penColor: "rgb(255, 255, 255)"
        });

        document.querySelector("button").addEventListener("click", function() {
            getSignaturePad();
            return true;
        });

        function getSignaturePad() {
            var imageData = signaturePad.toDataURL();
            document.getElementsByName("image")[0].setAttribute("value", imageData);
        }

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // otherwise isEmpty() might return incorrect value
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();
    </script>

</body>

</html>
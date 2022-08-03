<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $namaJudul; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-dark text-white">
    <img src="https://www.personality-database.com/profile_images/451585.png" alt="Logo Cyber" class="mt-5 rounded-circle mb-5 mx-auto d-block" width="100">
    <div class="row justify-content-center">
        <div class="col-sm-5 px-3">
            <div class="card text-center text-dark">
                <div class="card-body">
                    <h3 class="card-title p-3 text-success mb-4"><?= $namaJudul; ?></h3>
                    <p class="card-text"><?= $message; ?></p>
                    <a href="/" class="text-success small">Go to home</a>
                </div>
                <div class="card-footer bg-secondary text-white fw-bold mt-2">
                    Cyber motto? (Yang beli bapaknya yang pake anaknya yang pamer pacarnya)
                </div>
            </div>
        </div>
    </div>
    <p class="text-center mt-3">2022-2023 © Presensi Cyber</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>
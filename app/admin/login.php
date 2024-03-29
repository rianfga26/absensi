<?php
session_start();
require_once 'database/mydbCon.php';

// middleware
if (!empty($_SESSION['login'])) {
    header('Location: /admin');
    exit();
}

$_SESSION["user_input"] = $_SESSION["pass_input"] = '';
$userErr = $passErr = $errMessage = '';

if (isset($_POST['submit'])) {
    $_SESSION["user_input"] = $_POST['username'];

    if (empty($_POST['username'])) {
        $userErr = 'Field username harus diisi.';
    } else if (empty($_POST['password'])) {
        $passErr = 'Field password harus diisi.';
    } elseif ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
        // destroy session username and login
        unset($_SESSION['user_input'], $_SESSION['pass_input']);
        // insert session login
        $_SESSION['login'] = $_POST['username'];

        // insert data login time
        $detik = time();
        $cek_waktu_lalu = "SELECT * FROM waktu_lalu LIMIT 1";
        $cekWaktu = mysqli_query($con, $cek_waktu_lalu);
        if ($cekWaktu->num_rows > 0) {
            $sql = "UPDATE waktu_lalu SET login=$detik WHERE id = 1";
        } else {
            $sql = "INSERT INTO waktu_lalu VALUES(0,$detik,0)";
        }
        
        $hasil = mysqli_query($con, $sql);

        if (!$hasil) {
            $errLogin = 'Tidak berhasil login!';
        }else{
            header("location: /admin");
            exit();
        }

    } else {
        $errMessage = 'Username atau Password anda salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cyber UNUSA - Login</title>

    <!-- Custom fonts for this template-->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="public/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-success">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center vh-100">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-left mb-4">
                                        <h1 class="h4 text-gray-900">Welcome Back!</h1>
                                        <p class="text-muted">Login to your account</p>
                                    </div>
                                    <form class="user" action="" method="POST">
                                        <?php
                                        if ($errMessage != '') {
                                            echo '
                                                <div class="alert alert-danger" role="alert">' . $errMessage . '</div>';
                                        } else if (isset($errLogin)) {
                                            echo '
                                                    <div class="alert alert-danger" role="alert">' . $errLogin . '</div>';
                                        }
                                        ?>
                                        <div class="form-group mb-4">
                                            <input type="text" class="form-control form-control-user <?= $userErr != '' ?  'border-danger' : '' ?> " id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username" name="username" value="<?= $_SESSION["user_input"] ?>">
                                            <?php
                                            if ($userErr != '') {
                                                echo '<span class="text-danger small m-2 text-lowercase"><i class="fas fa-exclamation-circle mr-1"></i>' . $userErr . '</span>';
                                            }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user <?= $passErr != '' ? 'border-danger' : '' ?>" id="exampleInputPassword" placeholder="Password" name="password" value="<?= $_SESSION["pass_input"] ?>">
                                            <?php
                                            if ($passErr != '') {
                                                echo '<span class="text-danger small m-2 text-lowercase"><i class="fas fa-exclamation-circle mr-1"></i>' . $passErr . '</span>';
                                            }
                                            ?>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success btn-user btn-block mt-4" name="submit">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="public/js/sb-admin-2.min.js"></script>

</body>

</html>
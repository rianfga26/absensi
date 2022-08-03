<?php
require_once 'database/mydbCon.php';
session_start();

$detik = time();
$cek_waktu_lalu = "SELECT * FROM waktu_lalu LIMIT 1";

$cekWaktu = mysqli_query($con, $cek_waktu_lalu);
if($cekWaktu->num_rows > 0) {
    $sql = "UPDATE waktu_lalu SET logout=$detik WHERE id = 1";
}else{
    $sql = "INSERT INTO waktu_lalu VALUES('', '',$detik)";
}

$hasil = mysqli_query($con, $sql);

if(!$hasil){
    $_SESSION['logoutErr'] = 'Tidak berhasil logout!';
    header('Location: /admin');
    exit();
}

session_destroy();

header('Location: /');
exit();
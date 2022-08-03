<?php
session_start();
require_once 'database/mydbCon.php';

// middleware
if (empty($_SESSION['login'])) {
    header('Location: /');
    exit();
}


if (count($param) > 1) {
    $id = (int) $param[1];
    $status = $param[0];
    if ($param[0] == 'open' && $param[1] != '') {
        $sql = "UPDATE kegiatan SET status = '$status' WHERE id = $id";
    } else if ($param[0] == 'close' && $param[1] != '') {
        $sql = "UPDATE kegiatan SET status = '$status' WHERE id = $id";
    } else {
        header('Location: /404');
        exit();
    }

    $nama = mysqli_query($con, "SELECT * FROM kegiatan WHERE id = $id");
    if ($nama->num_rows > 0) {
        while ($row = $nama->fetch_assoc()) {
            $judul = join('-', explode(' ', $row['nama']));
            setcookie($judul, "", 0, "/kegiatan");
        }
    }

    $result = mysqli_query($con, $sql);
    // var_dump($result); die;
    if ($result) {
        header('Location: /');
        exit();
    }
} else {
    header('Location: /');
    exit();
}

<?php
session_start();
require_once 'database/mydbCon.php';
require_once 'config/Time.php';

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

// middleware
if (empty($_SESSION['login'])) {
    header('Location: /');
    exit();
}

// waktu lalu
$sql = "SELECT * FROM waktu_lalu LIMIT 1";
$result = mysqli_query($con, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $login = (int) $row['login'];
        $logout = (int) $row['logout'];
    }

    if ($logout == 0) {
        $seconds = time() - $login;
    } else {
        $seconds = $login - $logout;
    }
}

// insert data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $id = $_POST['idSpreadsheet'];
    $sheet = $_POST['namaSheet'];
    $status = 'open';
    $tgl = date('Y-m-d');

    if(isset($_POST['edit'])){
        $sql = "UPDATE kegiatan SET nama='$nama', spreadsheetID='$id',nama_sheet='$sheet'";
    }else{
        $sql = "INSERT INTO kegiatan VALUES(0,'$nama','$id','$sheet','$status','$tgl')";
    }
    
    $result = mysqli_query($con, $sql);

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

    <title>Admin Absensi Cyber</title>

    <!-- Custom fonts for this template -->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <img src="https://icon-library.com/images/8bit-icon/8bit-icon-17.jpg" alt="p" class="w-25 rounded-circle">
                <div>Admin Absensi Cyber</div>

            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">



            <!-- Divider -->
            <hr class="sidebar-divider">







            <!-- Divider -->
            <hr class="sidebar-divider">







            <!-- Nav Item - Tables -->

            <li class="nav-item">
                <a class="nav-link" href="">
                    <span>Kegiatan</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <span class="p-3 text-muted small"> <span class="text-primary"> Terakhir login :</span> <?= waktu_lalu($seconds) ?></span>
                        </li>
                    </ul>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>




                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['login'] ?></span>
                                <img class="img-profile rounded-circle" src="https://icon-library.com/images/8bit-icon/8bit-icon-17.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Table Kegiatan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kegiatan</th>
                                            <th>Id Spreadsheet</th>
                                            <th>Nama Sheet</th>
                                            <th>Status</th>
                                            <th class="text-center">
                                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#insertModal"> <i class="bi bi-plus-lg"></i> tambah data</button>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // tampilkan data
                                        $sql = "SELECT * FROM kegiatan";

                                        $no = 1;
                                        $hasil = mysqli_query($con, $sql);
                                        if ($hasil->num_rows > 0) {
                                            while ($row = $hasil->fetch_assoc()) {
                                                $judul = explode(' ', $row['nama']);
                                                $now = date_create($row['tgl']);
                                        ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= date_format($now, "d M Y") ?></td>
                                                    <td><?= $row['nama'] ?></td>
                                                    <td class="text-break"><?= $row['spreadsheetID'] ?></td>
                                                    <td><?= $row['nama_sheet'] ?></td>
                                                    <td><?= $row['status'] ?></td>
                                                    <td class="text-center flex align-items-center">
                                                        <button class="btn btn-sm btn-warning mb-4 " data-toggle="modal" data-target="#editModal" onclick="get_id(<?= $row['id'] ?>)"><i class="bi bi-pencil-fill"></i> ubah</button>

                                                        <a class="btn btn-sm btn-secondary mb-4" href="<?= $actual_link . "/kegiatan/" . join('-', $judul) ?>" target="_blank"><i class="bi bi-link"></i> get link</a>
                                                        <a href="https://docs.google.com/spreadsheets/d/<?= $row['spreadsheetID'] ?>" class="btn btn-primary mb-4" target="_blank"><i class="bi bi-arrow-up-right"></i> goto spreadsheet</a>
                                                        <a href="admin/open/<?= $row['id'] ?>" class="btn btn-sm btn-success"><i class="bi bi-box-arrow-left"></i> open</a>
                                                        <a href="admin/close/<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-in-right"></i> close</a>
                                                    </td>

                                                </tr>
                                        <?php

                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- insert modal -->
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="container">
                            <small>Format pembuatan spreadsheet tgl,nama,nim,prodi,link ttd . (<a href="public/image/contoh-format-spreedsheet.png" target="_blank">Lihat Contoh</a>)</small>
                            <div class="form-group mt-4">
                                <label for="kegiatan">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="kegiatan" placeholder="cth: Seminar Cyber Internasional" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="idSpreedsheet">Id Spreedsheet</label>
                                <input type="text" class="form-control" id="idSpreedsheet" placeholder="cth: 1B0sdI4tMjs0YZ8cMrL_l3irEKZivKVE65o" name="idSpreadsheet" required>
                                <small>Id Spreedsheet bisa diambil dari url google spreadsheet yang telah dibuat. (<a href="public/image/contoh-idspreedsheet.png" target="_blank">Lihat Contoh</a>)</small>
                            </div>
                            <div class="form-group">
                                <label for="namaSheet">Nama Sheet</label>
                                <input type="text" class="form-control" id="namaSheet" placeholder="cth: Sheet1/Absen" name="namaSheet" required>
                                <small>Nama Sheet bisa dilihat dibawah kiri. (<a href="public/image/contoh-namasheet.png" target="_blank">Lihat Contoh</a>)</small>
                            </div>
                            <p>Note : <b>Setelah membuat spreadsheet tambahkan akses email (absensi-cyber@absensi-cyber.iam.gserviceaccount.com) ini di tombol bagikan.</b></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="container">
                            <input type="hidden" name="edit">
                            <div class="form-group">
                                <label for="kegiatan">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="editKegiatan" placeholder="cth: Seminar Cyber Internasional" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="idSpreedsheet">Id Spreedsheet</label>
                                <input type="text" class="form-control" id="editIdSpreedsheet" placeholder="cth: 1B0sdI4tMjs0YZ8cMrL_l3irEKZivKVE65o" name="idSpreadsheet" required>
                                <small>Id Spreedsheet bisa diambil dari url google spreadsheet yang telah dibuat. (<a href="public/image/contoh-idspreedsheet.png" target="_blank">Lihat Contoh</a>)</small>
                            </div>
                            <div class="form-group">
                                <label for="namaSheet">Nama Sheet</label>
                                <input type="text" class="form-control" id="editNamaSheet" placeholder="cth: Sheet1/Absen" name="namaSheet" required>
                                <small>Nama Sheet bisa dilihat dibawah kiri. (<a href="public/image/contoh-namasheet.png" target="_blank">Lihat Contoh</a>)</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                    </div>
                </form>
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

    <!-- Page level plugins -->
    <script src="public/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="public/js/demo/datatables-demo.js"></script>

    <script>
        function get_id(id) {
            fetch('admin/edit/'+id)
                .then(response => response.json())
                .then(res => {
                    if(res.status == 'berhasil'){
                        const nama = document.getElementById('editKegiatan');
                        const id = document.getElementById('editIdSpreedsheet');
                        const nama_sheet = document.getElementById('editNamaSheet');
                        nama.value = res.data.nama;
                        id.value = res.data.spreadsheetID;
                        nama_sheet.value = res.data.nama_sheet;
                    }
                })
                .catch(err => console.log(err))
        }
    </script>
</body>

</html>
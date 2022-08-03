<?php 
require_once 'database/mydbCon.php';

// var_dump($param); die;

if (count($param) == 1) {
    header("Location: /");
    exit();
}

$id = (int) $param[1];
$sql = "SELECT * FROM kegiatan WHERE id=$id";
$result = mysqli_query($con,$sql);

if($result->num_rows > 0 ){
    while($row = $result->fetch_assoc()){
        echo json_encode([
            'status' => 'berhasil',
            'data' => $row
        ]);
    }
}else{
    echo json_encode([
        'status' => 'gagal',
        'message' => 'data tidak ada!'
    ]);
}
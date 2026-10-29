<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
include "../phpqrcode/qrlib.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($koneksi,"
SELECT *
FROM siswa
WHERE id_siswa='$id'
"));

if(!$data){
    die("Data tidak ditemukan");
}

$tempDir="../temp/";

if(!file_exists($tempDir)){
    mkdir($tempDir);
}

$file=$tempDir.$data['nis'].".png";

QRcode::png(
    $data['nis'],
    $file,
    QR_ECLEVEL_H,
    8,
    2
);
?>

<!DOCTYPE html>
<html>

<head>

<title>Cetak QR</title>

<style>

body{

font-family:Arial;

}

.card{

width:350px;

border:2px solid black;

padding:20px;

margin:auto;

text-align:center;

}

img{

margin-top:10px;

}

h2{

margin-bottom:5px;

}

</style>

</head>

<body onload="window.print()">

<div class="card">

<h2>ABSENSI SISWA</h2>

<hr>

<h3><?= $data['nama_siswa']; ?></h3>

<p>

<b>NIS</b>

<?= $data['nis']; ?>

</p>

<p>

<b>Kelas</b>

<?= $data['kelas']; ?>

</p>

<img src="<?= $file ?>" width="220">

<p>

Scan QR saat absensi

</p>

</div>

</body>

</html>
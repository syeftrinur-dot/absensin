<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";
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

$fileName=$tempDir.$data['nis'].".png";

QRcode::png(
    $data['nis'],
    $fileName,
    QR_ECLEVEL_H,
    10,
    2
);

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>QR Code Siswa</h4>

</div>

<div class="card-body text-center">

<h3><?= $data['nama_siswa']; ?></h3>

<p>NIS : <?= $data['nis']; ?></p>

<img
src="<?= $fileName ?>"
class="img-thumbnail"
width="300">

<br><br>

<a
href="<?= $fileName ?>"
download
class="btn btn-success">

Download QR

</a>

<a
href="siswa.php"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";
require_once "../../phpqrcode/qrlib.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'");
$siswa = mysqli_fetch_assoc($query);

$isiQR = $siswa['nis'];

$folder = "../../qrcode/";

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$file = $folder.$isiQR.".png";

QRcode::png($isiQR, $file, QR_ECLEVEL_L, 8, 2);
?>

<?php
$path = "qrcode/".$isiQR.".png";
mysqli_query($koneksi, "UPDATE siswa SET qr_code='$path' WHERE id_siswa='$id'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 text-center">

    <h3><?= $siswa['nama_siswa']; ?></h3>

    <img src="../../qrcode/<?= $isiQR; ?>.png">

    <p class="mt-3">
        NIS : <b><?= $siswa['nis']; ?></b>
    </p>

<a href="../../<?= $siswa['qr_code'] ?>"
   download="<?= basename($siswa['qr_code']) ?>"
   class="btn btn-success">
    Download PNG
</a>
</div>

</body>
</html>
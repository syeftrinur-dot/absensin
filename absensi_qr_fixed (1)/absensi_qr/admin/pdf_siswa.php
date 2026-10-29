<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";
require_once "../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// =========================
// Ambil ID
// =========================

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);

// =========================
// Ambil Data Siswa
// =========================

$query = mysqli_query($koneksi, "
SELECT *
FROM siswa
WHERE id_siswa='$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data siswa tidak ditemukan.");
}

// =========================
// Generate QR jika belum ada
// =========================

include "../phpqrcode/qrlib.php";

$tempDir = "../temp/";

if (!file_exists($tempDir)) {
    mkdir($tempDir, 0777, true);
}

$qrFile = $tempDir . $data['nis'] . ".png";

if (!file_exists($qrFile)) {

    QRcode::png(
        $data['nis'],
        $qrFile,
        QR_ECLEVEL_H,
        8,
        2
    );

}

// =========================
// Encode QR ke Base64
// =========================

$imgData = base64_encode(file_get_contents($qrFile));

$qr = "data:image/png;base64,".$imgData;

// =========================
// HTML PDF
// =========================

$html = '

<style>

body{

font-family:DejaVu Sans;

font-size:13px;

}

.card{

border:2px solid #0d6efd;

border-radius:10px;

padding:20px;

width:100%;

}

h2{

text-align:center;

margin-bottom:5px;

color:#0d6efd;

}

hr{

margin:10px 0;

}

table{

width:100%;

border-collapse:collapse;

}

td{

padding:6px;

}

.qr{

text-align:center;

margin-top:20px;

}

.footer{

margin-top:15px;

text-align:center;

font-size:12px;

color:#777;

}

</style>

<div class="card">

<h2>SISTEM ABSENSI QR</h2>

<div style="text-align:center">

<b>KARTU ABSENSI SISWA</b>

</div>

<hr>

<table>

<tr>

<td width="120"><b>NIS</b></td>

<td>: '.$data['nis'].'</td>

</tr>

<tr>

<td><b>Nama</b></td>

<td>: '.$data['nama_siswa'].'</td>

</tr>

<tr>

<td><b>Jenis Kelamin</b></td>

<td>: '.$data['jk'].'</td>

</tr>

<tr>

<td><b>Kelas</b></td>

<td>: '.$data['kelas'].'</td>

</tr>

<tr>

<td><b>Alamat</b></td>

<td>: '.$data['alamat'].'</td>

</tr>

</table>

<div class="qr">

<img src="'.$qr.'" width="220">

</div>

<div class="footer">

Scan QR ini saat melakukan absensi.

</div>

</div>

';

// =========================
// DOMPDF
// =========================

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4','portrait');

$dompdf->render();

$dompdf->stream(
    "Kartu_QR_".$data['nis'].".pdf",
    ["Attachment"=>false]
);
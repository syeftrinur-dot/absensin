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

$tanggal = isset($_GET['tanggal'])
    ? $_GET['tanggal']
    : date('Y-m-d');

$query = mysqli_query($koneksi,"
SELECT
    absensi.*,
    siswa.nis,
    siswa.nama_siswa,
    kelas.nama_kelas,
    mapel.nama_mapel,
    guru.nama_guru

FROM absensi

JOIN siswa
ON absensi.id_siswa=siswa.id_siswa

JOIN jadwal
ON absensi.id_jadwal=jadwal.id_jadwal

JOIN guru
ON jadwal.id_guru=guru.id_guru

JOIN kelas
ON jadwal.id_kelas=kelas.id_kelas

JOIN mapel
ON jadwal.id_mapel=mapel.id_mapel

WHERE absensi.tanggal='$tanggal'

ORDER BY
kelas.nama_kelas,
siswa.nama_siswa
");

$logo = "";

if(file_exists("../assets/img/logo.png")){
    $logo = "../assets/img/logo.png";
}

$html='
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<style>

body{

font-family:DejaVu Sans;

font-size:11px;

}

.header{

width:100%;

border-bottom:3px solid black;

padding-bottom:10px;

margin-bottom:20px;

}

.logo{

width:90px;

float:left;

}

.judul{

text-align:center;

line-height:1.5;

}

.clear{

clear:both;

}

table{

width:100%;

border-collapse:collapse;

margin-top:15px;

}

table th{

background:#0d6efd;

color:white;

}

table th,
table td{

border:1px solid #000;

padding:6px;

font-size:11px;

}

table td{

text-align:center;

}

.footer{

margin-top:60px;

width:100%;

}

.ttd{

width:250px;

float:right;

text-align:center;

}

</style>

</head>

<body>';

if($logo!=""){

$html.='

<div class="header">

<img src="'.$logo.'" class="logo">

<div class="judul">

<h2 style="margin:0;">SISTEM ABSENSI QR CODE</h2>

<h3 style="margin:0;">LAPORAN ABSENSI SISWA</h3>

<div>SMK / SMP ANDA</div>

<div>Jl. ....................................................</div>

</div>

<div class="clear"></div>

</div>

';

}else{

$html.='

<h2 style="text-align:center;margin-bottom:0;">

SISTEM ABSENSI QR CODE

</h2>

<h3 style="text-align:center;margin-top:5px;">

LAPORAN ABSENSI SISWA

</h3>

<hr>

';

}

$html.='

<p>

<b>Tanggal :</b>

'.date('d-m-Y',strtotime($tanggal)).'

</p>

<table>

<tr>

<th width="40">No</th>

<th>NIS</th>

<th>Nama</th>

<th>Kelas</th>

<th>Mapel</th>

<th>Guru</th>

<th>Jam</th>

<th>Status</th>

</tr>

';

$no=1;

while($d=mysqli_fetch_assoc($query)){

$status=$d['status'];

$warna="#198754";

if(strtolower($status)=="izin"){

$warna="#ffc107";

}elseif(strtolower($status)=="sakit"){

$warna="#0dcaf0";

}elseif(strtolower($status)=="alpha"){

$warna="#dc3545";

}

$html.='

<tr>

<td>'.$no++.'</td>

<td>'.$d['nis'].'</td>

<td style="text-align:left">'.$d['nama_siswa'].'</td>

<td>'.$d['nama_kelas'].'</td>

<td>'.$d['nama_mapel'].'</td>

<td>'.$d['nama_guru'].'</td>

<td>'.substr($d['jam_masuk'],0,5).'</td>

<td style="color:white;background:'.$warna.';font-weight:bold;">

'.$status.'

</td>

</tr>

';

}

$html.='

</table>

<div class="footer">

<div class="ttd">

<p>

Cirebon,

'.date('d-m-Y').'

</p>

<p>

Administrator

</p>

<br><br><br>

<b>

'.htmlspecialchars($_SESSION['nama']).'

</b>

</div>

</div>

</body>

</html>

';

$options = new Options();

$options->set('isRemoteEnabled',true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper("A4","landscape");

$dompdf->render();

$dompdf->stream(

"Laporan_Absensi_".$tanggal.".pdf",

["Attachment"=>false]

);
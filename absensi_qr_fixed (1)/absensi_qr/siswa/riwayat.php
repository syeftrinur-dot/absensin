<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";

include "layout/header.php";
include "layout/sidebar.php";

$idSiswa=$_SESSION['id_siswa'];

$query=mysqli_query($koneksi,"

SELECT

absensi.*,

mapel.nama_mapel,

guru.nama_guru

FROM absensi

INNER JOIN jadwal

ON absensi.id_jadwal=jadwal.id_jadwal

INNER JOIN mapel

ON jadwal.id_mapel=mapel.id_mapel

INNER JOIN guru

ON jadwal.id_guru=guru.id_guru

WHERE absensi.id_siswa='$idSiswa'

ORDER BY

absensi.tanggal DESC,

absensi.jam_masuk DESC

");

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

Riwayat Absensi

</h2>

<p class="text-secondary">

Riwayat seluruh absensi yang pernah Anda lakukan.

</p>

</div>

<div class="col-lg-4 text-end">

<span class="badge bg-primary fs-6">

<?= date("d-m-Y"); ?>

</span>

</div>

</div>
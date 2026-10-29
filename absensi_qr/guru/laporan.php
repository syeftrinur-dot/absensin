<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="guru"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";
include "layout/header.php";
include "layout/sidebar.php";

$idGuru=$_SESSION['id_guru'];

$tanggal1 = isset($_GET['tanggal1']) ? $_GET['tanggal1'] : "";
$tanggal2 = isset($_GET['tanggal2']) ? $_GET['tanggal2'] : "";

$sql="

SELECT

absensi.*,

siswa.nis,

siswa.nama_siswa,

kelas.nama_kelas,

mapel.nama_mapel

FROM absensi

INNER JOIN siswa

ON siswa.id_siswa=absensi.id_siswa

INNER JOIN jadwal

ON jadwal.id_jadwal=absensi.id_jadwal

INNER JOIN kelas

ON kelas.id_kelas=jadwal.id_kelas

INNER JOIN mapel

ON mapel.id_mapel=jadwal.id_mapel

WHERE jadwal.id_guru='$idGuru'

";

if($tanggal1!="" && $tanggal2!=""){

$sql.=" AND absensi.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ";

}

$sql.="

ORDER BY

absensi.tanggal DESC,

absensi.jam_masuk DESC

";

$query=mysqli_query($koneksi,$sql);

/* ==============================
   RINGKASAN
============================== */

$total=mysqli_num_rows($query);

$hadir=0;
$izin=0;
$sakit=0;
$alpha=0;

mysqli_data_seek($query,0);

while($r=mysqli_fetch_assoc($query)){

switch($r['status']){

case "Hadir":
$hadir++;
break;

case "Izin":
$izin++;
break;

case "Sakit":
$sakit++;
break;

default:
$alpha++;

}

}

mysqli_data_seek($query,0);

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Laporan Absensi

</h2>

<p class="text-secondary">

Laporan absensi siswa berdasarkan jadwal mengajar.

</p>

</div>

<div class="col-md-4 text-end">

<a

href="cetak_pdf.php?tanggal1=<?= $tanggal1 ?>&tanggal2=<?= $tanggal2 ?>"

target="_blank"

class="btn btn-danger">

<i class="fa-solid fa-file-pdf"></i>

Export PDF

</a>

</div>

</div>
<!-- =====================================
     KARTU RINGKASAN
===================================== -->

<div class="row g-4 mb-4">

    <div class="col-lg-3 col-md-6">

        <div class="stat-card bg-primary-gradient">

            <small>Total Absensi</small>

            <h2><?= $total ?></h2>

            <div class="icon">

                <i class="fa-solid fa-clipboard-list"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="stat-card bg-success-gradient">

            <small>Hadir</small>

            <h2><?= $hadir ?></h2>

            <div class="icon">

                <i class="fa-solid fa-circle-check"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="stat-card bg-warning-gradient">

            <small>Izin</small>

            <h2><?= $izin ?></h2>

            <div class="icon">

                <i class="fa-solid fa-envelope-open"></i>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="stat-card bg-danger">

            <small>Sakit / Alpha</small>

            <h2><?= $sakit + $alpha ?></h2>

            <div class="icon">

                <i class="fa-solid fa-user-xmark"></i>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
     FILTER
===================================== -->

<div class="card mb-4">

    <div class="card-header">

        <i class="fa-solid fa-filter text-primary"></i>

        Filter Laporan

    </div>

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <label class="form-label">

                        Tanggal Awal

                    </label>

                    <input
                    type="date"
                    name="tanggal1"
                    value="<?= $tanggal1 ?>"
                    class="form-control">

                </div>

                <div class="col-md-4">

                    <label class="form-label">

                        Tanggal Akhir

                    </label>

                    <input
                    type="date"
                    name="tanggal2"
                    value="<?= $tanggal2 ?>"
                    class="form-control">

                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">

                    <button class="btn btn-primary">

                        <i class="fa fa-search"></i>

                        Filter

                    </button>

                    <a
                    href="laporan.php"
                    class="btn btn-secondary">

                        <i class="fa fa-rotate"></i>

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- =====================================
     TABEL
===================================== -->

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <span>

            <i class="fa-solid fa-table text-success"></i>

            Data Laporan Absensi

        </span>

        <span class="badge bg-primary">

            <?= $total ?> Data

        </span>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover table-striped datatable">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>NIS</th>

                        <th>Nama</th>

                        <th>Kelas</th>

                        <th>Mapel</th>

                        <th>Jam</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

<?php

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= date('d-m-Y',strtotime($d['tanggal'])) ?></td>

<td><?= htmlspecialchars($d['nis']) ?></td>

<td><?= htmlspecialchars($d['nama_siswa']) ?></td>

<td><?= htmlspecialchars($d['nama_kelas']) ?></td>

<td><?= htmlspecialchars($d['nama_mapel']) ?></td>

<td><?= substr($d['jam_masuk'],0,5) ?></td>

<td>

<?php

switch($d['status']){

case "Hadir":

echo "<span class='badge bg-success'>Hadir</span>";

break;

case "Izin":

echo "<span class='badge bg-warning text-dark'>Izin</span>";

break;

case "Sakit":

echo "<span class='badge bg-info'>Sakit</span>";

break;

default:

echo "<span class='badge bg-danger'>".$d['status']."</span>";

}

?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>
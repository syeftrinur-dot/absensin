<?php

include "../koneksi.php";

include "layout/header.php";

include "layout/sidebar.php";

/* ===================================
   IDENTITAS GURU
=================================== */

$idGuru = $_SESSION['id_guru'];

$qGuru = mysqli_query($koneksi,"
SELECT *
FROM guru
WHERE id_guru='$idGuru'
");

$guru = mysqli_fetch_assoc($qGuru);

/* ===================================
   TANGGAL
=================================== */

$hariIndonesia = [
    "Sunday"=>"Minggu",
    "Monday"=>"Senin",
    "Tuesday"=>"Selasa",
    "Wednesday"=>"Rabu",
    "Thursday"=>"Kamis",
    "Friday"=>"Jumat",
    "Saturday"=>"Sabtu"
];

$hari = $hariIndonesia[date("l")];

$tanggal = date("Y-m-d");

/* ===================================
   TOTAL JADWAL HARI INI
=================================== */

$qJadwal = mysqli_query($koneksi,"
SELECT COUNT(*) total
FROM jadwal
WHERE id_guru='$idGuru'
AND hari='$hari'
");

$totalJadwal = mysqli_fetch_assoc($qJadwal)['total'];

/* ===================================
   TOTAL ABSENSI HARI INI
=================================== */

$qAbsensi = mysqli_query($koneksi,"
SELECT COUNT(*) total
FROM absensi
WHERE tanggal='$tanggal'
");

$totalAbsensi = mysqli_fetch_assoc($qAbsensi)['total'];

/* ===================================
   TOTAL KELAS
=================================== */

$qKelas = mysqli_query($koneksi,"
SELECT COUNT(DISTINCT id_kelas) total
FROM jadwal
WHERE id_guru='$idGuru'
");

$totalKelas = mysqli_fetch_assoc($qKelas)['total'];

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Dashboard Guru

</h2>

<p class="text-secondary">

Selamat datang,

<b><?= htmlspecialchars($guru['nama_guru']) ?></b>

</p>

</div>

<div class="col-md-4 text-end">

<span class="badge bg-primary fs-6">

<?= $hari ?>,

<?= date('d-m-Y') ?>

</span>

</div>

</div>

<div class="row g-4">
<!-- ==========================
     JADWAL HARI INI
========================== -->

<div class="col-lg-4 col-md-6">

    <div class="stat-card bg-primary-gradient">

        <small>Jadwal Hari Ini</small>

        <h2><?= $totalJadwal ?></h2>

        <div class="icon">

            <i class="fa-solid fa-calendar-days"></i>

        </div>

    </div>

</div>

<!-- ==========================
     ABSENSI HARI INI
========================== -->

<div class="col-lg-4 col-md-6">

    <div class="stat-card bg-success-gradient">

        <small>Absensi Hari Ini</small>

        <h2><?= $totalAbsensi ?></h2>

        <div class="icon">

            <i class="fa-solid fa-clipboard-check"></i>

        </div>

    </div>

</div>

<!-- ==========================
     TOTAL KELAS
========================== -->

<div class="col-lg-4 col-md-6">

    <div class="stat-card bg-warning-gradient">

        <small>Total Kelas</small>

        <h2><?= $totalKelas ?></h2>

        <div class="icon">

            <i class="fa-solid fa-school"></i>

        </div>

    </div>

</div>

</div>

<!-- END ROW -->


<!-- ==========================
     JADWAL MENGAJAR
========================== -->

<div class="row mt-4">

<div class="col-lg-12">

<div class="card">

<div class="card-header">

<i class="fa-solid fa-calendar-day text-primary"></i>

Jadwal Mengajar Hari Ini

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Mata Pelajaran</th>

<th>Kelas</th>

<th>Jam</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

$q=mysqli_query($koneksi,"
SELECT
jadwal.*,
mapel.nama_mapel,
kelas.nama_kelas
FROM jadwal
JOIN mapel ON mapel.id_mapel=jadwal.id_mapel
JOIN kelas ON kelas.id_kelas=jadwal.id_kelas
WHERE jadwal.id_guru='$idGuru'
AND jadwal.hari='$hari'
ORDER BY jadwal.jam_mulai
");

if(mysqli_num_rows($q)>0){

while($d=mysqli_fetch_assoc($q)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($d['nama_mapel']) ?></td>

<td><?= htmlspecialchars($d['nama_kelas']) ?></td>

<td>

<?= substr($d['jam_mulai'],0,5) ?>

-

<?= substr($d['jam_selesai'],0,5) ?>

</td>

<td>

<a
href="scan.php?id=<?= $d['id_jadwal'] ?>"
class="btn btn-primary btn-sm">

<i class="fa-solid fa-qrcode"></i>

Scan QR

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center text-secondary">

Belum ada jadwal mengajar hari ini.

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>
<!-- ============================================
     RIWAYAT ABSENSI TERBARU
============================================= -->

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header">

                <i class="fa-solid fa-clock-rotate-left text-success"></i>

                Riwayat Absensi Terbaru

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Nama Siswa</th>

                                <th>Kelas</th>

                                <th>Tanggal</th>

                                <th>Jam Masuk</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

<?php

$no = 1;

$qRiwayat = mysqli_query($koneksi,"
SELECT
absensi.*,
siswa.nama_siswa,
siswa.kelas,
jadwal.id_guru
FROM absensi
INNER JOIN siswa
ON siswa.id_siswa=absensi.id_siswa
INNER JOIN jadwal
ON jadwal.id_jadwal=absensi.id_jadwal
WHERE jadwal.id_guru='$idGuru'
ORDER BY absensi.id_absensi DESC
LIMIT 10
");

if(mysqli_num_rows($qRiwayat)>0){

while($d=mysqli_fetch_assoc($qRiwayat)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($d['nama_siswa']) ?></td>

<td><?= htmlspecialchars($d['kelas']) ?></td>

<td><?= date('d-m-Y',strtotime($d['tanggal'])) ?></td>

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

echo "<span class='badge bg-danger'>Alpha</span>";

}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" class="text-center text-secondary">

Belum ada data absensi.

</td>

</tr>

<?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>
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

/* ===========================
   IDENTITAS GURU
=========================== */

$idGuru = $_SESSION['id_guru'];

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

/* ===========================
   JADWAL GURU
=========================== */

$query = mysqli_query($koneksi,"
SELECT
jadwal.*,
kelas.nama_kelas,
mapel.nama_mapel
FROM jadwal
INNER JOIN kelas
ON kelas.id_kelas=jadwal.id_kelas
INNER JOIN mapel
ON mapel.id_mapel=jadwal.id_mapel
WHERE jadwal.id_guru='$idGuru'
ORDER BY
FIELD(jadwal.hari,
'Senin',
'Selasa',
'Rabu',
'Kamis',
'Jumat',
'Sabtu'),
jadwal.jam_mulai
");

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Jadwal Mengajar

</h2>

<p class="text-secondary">

Daftar seluruh jadwal mengajar Anda.

</p>

</div>

<div class="col-md-4 text-end">

<span class="badge bg-primary fs-6">

<?= $hari; ?>

</span>

</div>

</div>
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <div>

            <i class="fa-solid fa-calendar-days text-primary"></i>

            Jadwal Mengajar

        </div>

        <span class="badge bg-primary">

            <?= mysqli_num_rows($query); ?> Jadwal

        </span>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle datatable">

                <thead>

                    <tr>

                        <th width="60">No</th>

                        <th>Hari</th>

                        <th>Jam</th>

                        <th>Mata Pelajaran</th>

                        <th>Kelas</th>

                        <th width="170">Aksi</th>

                    </tr>

                </thead>

                <tbody>

<?php

$no=1;

if(mysqli_num_rows($query)>0){

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td>

<span class="badge bg-info">

<?= htmlspecialchars($d['hari']); ?>

</span>

</td>

<td>

<?= substr($d['jam_mulai'],0,5); ?>

-

<?= substr($d['jam_selesai'],0,5); ?>

</td>

<td>

<?= htmlspecialchars($d['nama_mapel']); ?>

</td>

<td>

<?= htmlspecialchars($d['nama_kelas']); ?>

</td>

<td>

<a
href="scan.php?id_jadwal=<?= $d['id_jadwal']; ?>"
class="btn btn-success btn-sm">

<i class="fa-solid fa-qrcode"></i>

Mulai Absensi

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6" class="text-center text-secondary">

Belum ada jadwal mengajar.

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
<!-- ==========================
     INFORMASI
========================== -->

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="alert alert-info border-0 shadow-sm">

            <i class="fa-solid fa-circle-info me-2"></i>

            Klik tombol <b>Mulai Absensi</b> untuk membuka halaman Scan QR sesuai jadwal yang dipilih.

        </div>

    </div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>

<script>

document.addEventListener("DOMContentLoaded",function(){

    let table=document.querySelector(".datatable");

    if(table){

        table.classList.add("table-striped");

    }

});

</script>
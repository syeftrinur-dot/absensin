<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

$cari="";

$where="";

if(isset($_GET['cari'])){

$cari=mysqli_real_escape_string($koneksi,$_GET['cari']);

$where="WHERE

guru.nama_guru LIKE '%$cari%'

OR

kelas.nama_kelas LIKE '%$cari%'

OR

mapel.nama_mapel LIKE '%$cari%'

OR

hari LIKE '%$cari%'";

}

$query=mysqli_query($koneksi,"
SELECT

jadwal.*,

guru.nama_guru,

kelas.nama_kelas,

mapel.nama_mapel

FROM jadwal

JOIN guru
ON jadwal.id_guru=guru.id_guru

JOIN kelas
ON jadwal.id_kelas=kelas.id_kelas

JOIN mapel
ON jadwal.id_mapel=mapel.id_mapel

$where

ORDER BY

FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'),

jam_mulai
");

$total=mysqli_num_rows($query);

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa fa-calendar text-primary"></i>

Data Jadwal

</h2>

<p class="text-muted">

Kelola seluruh jadwal pelajaran.

</p>

</div>

<div class="col-lg-4 text-end">

<a
href="tambah_jadwal.php"
class="btn btn-primary rounded-pill px-4">

<i class="fa fa-plus"></i>

Tambah Jadwal

</a>

</div>

</div>

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="GET">

<div class="row g-3 align-items-end">

<div class="col-lg-6">

<label class="form-label">

Cari Jadwal

</label>

<div class="input-group">

<span class="input-group-text">

<i class="fa fa-search"></i>

</span>

<input

type="text"

name="cari"

class="form-control"

placeholder="Cari Guru, Kelas, Mapel..."

value="<?= $cari ?>">

</div>

</div>

<div class="col-lg-2 d-grid">

<button class="btn btn-success">

<i class="fa fa-search"></i>

Cari

</button>

</div>

<div class="col-lg-2 d-grid">

<a

href="jadwal.php"

class="btn btn-secondary">

<i class="fa fa-rotate"></i>

Refresh

</a>

</div>

<div class="col-lg-2 text-end">

<span class="badge bg-primary fs-6">

<?= $total ?>

Data

</span>

</div>

</div>

</form>

<hr>

<div class="table-responsive">

<table

id="jadwalTable"

class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Guru</th>

<th>Kelas</th>

<th>Mapel</th>

<th>Hari</th>

<th>Jam</th>

<th width="170">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

if($total>0){

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($d['nama_guru']) ?></td>

<td><?= htmlspecialchars($d['nama_kelas']) ?></td>

<td><?= htmlspecialchars($d['nama_mapel']) ?></td>

<td>

<span class="badge bg-info">

<?= $d['hari'] ?>

</span>

</td>

<td>

<?= substr($d['jam_mulai'],0,5) ?>

-

<?= substr($d['jam_selesai'],0,5) ?>

</td>

<td>

<div class="btn-group">

<a

href="edit_jadwal.php?id=<?= $d['id_jadwal'] ?>"

class="btn btn-warning btn-sm">

<i class="fa fa-pen"></i>

</a>

<a

href="#"

class="btn btn-danger btn-sm"

onclick="konfirmasi('hapus_jadwal.php?id=<?= $d['id_jadwal'] ?>')">

<i class="fa fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php }

}else{

?>

<tr>

<td colspan="7"

class="text-center text-muted py-5">

<i class="fa fa-folder-open fa-3x"></i>

<br>

Belum ada data jadwal.

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

$(function(){

$('#jadwalTable').DataTable({

responsive:true,

autoWidth:false,

pageLength:10,

language:{

search:"Cari :",

lengthMenu:"Tampilkan _MENU_ data",

zeroRecords:"Data tidak ditemukan",

info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",

paginate:{

first:"Awal",

last:"Akhir",

next:"»",

previous:"«"

}

}

});

});

</script>

<?php include "../layout/footer.php"; ?>
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

$cari = "";

$where = "";

if(isset($_GET['cari'])){

    $cari = mysqli_real_escape_string($koneksi,$_GET['cari']);

    $where = "WHERE
                kode_kelas LIKE '%$cari%'
                OR nama_kelas LIKE '%$cari%'
                OR wali_kelas LIKE '%$cari%'";

}

$query = mysqli_query($koneksi,"
SELECT *
FROM kelas
$where
ORDER BY nama_kelas ASC
");

$total = mysqli_num_rows($query);

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid"><div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa-solid fa-school text-primary"></i>

Data Kelas

</h2>

<p class="text-muted">

Kelola seluruh data kelas yang tersedia pada sistem.

</p>

</div>

<div class="col-lg-4 text-end">

<a href="tambah_kelas.php"

class="btn btn-primary rounded-pill px-4">

<i class="fa fa-plus"></i>

Tambah Kelas

</a>

</div>

</div><div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="GET">

<div class="row g-3 align-items-end">

<div class="col-lg-6">

<label class="form-label">

Cari Data

</label>

<div class="input-group">

<span class="input-group-text">

<i class="fa fa-search"></i>

</span>

<input

type="text"

name="cari"

class="form-control"

placeholder="Cari kode, nama atau wali kelas..."

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

<a href="kelas.php"

class="btn btn-secondary">

<i class="fa fa-rotate"></i>

Refresh

</a>

</div>

<div class="col-lg-2 text-end">

<span class="badge bg-primary fs-6">

<?= $total ?> Data

</span>

</div>

</div>

</form>

<hr><div class="table-responsive">

<table

id="kelasTable"

class="table table-hover align-middle">

<thead>

<tr>

<th width="70">

No

</th>

<th>

Kode

</th>

<th>

Nama Kelas

</th>

<th>

Wali Kelas

</th>

<th width="160">

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

<td>

<?= htmlspecialchars($d['kode_kelas']) ?>

</td>

<td>

<strong>

<?= htmlspecialchars($d['nama_kelas']) ?>

</strong>

</td>

<td>

<?= htmlspecialchars($d['wali_kelas']) ?>

</td>

<td>

<div class="btn-group">

<a

href="edit_kelas.php?id=<?= $d['id_kelas'] ?>"

class="btn btn-warning btn-sm"

title="Edit">

<i class="fa fa-pen"></i>

</a>

<a

href="#"

class="btn btn-danger btn-sm"

onclick="konfirmasi('hapus_kelas.php?id=<?= $d['id_kelas'] ?>')"

title="Hapus">

<i class="fa fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5"

class="text-center text-muted py-5">

<i class="fa fa-folder-open fa-3x mb-3"></i>

<br>

Belum ada data kelas.

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

$(document).ready(function(){

$('#kelasTable').DataTable({

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
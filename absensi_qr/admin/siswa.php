<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
include "../layout/header.php";
include "../layout/sidebar.php";

$cari = "";

if(isset($_GET['cari'])){
    $cari = mysqli_real_escape_string($koneksi,$_GET['cari']);
}

$query = mysqli_query($koneksi,"
SELECT *
FROM siswa
WHERE nama_siswa LIKE '%$cari%'
OR nis LIKE '%$cari%'
ORDER BY nama_siswa ASC
");

$total = mysqli_num_rows($query);
?>
<div class="content">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">

<h3>Data Siswa</h3>

<a href="tambah_siswa.php" class="btn btn-primary">
Tambah Siswa
</a>

</div>

<form method="GET">

<div class="row mb-3">

<div class="col-md-4">

<div class="input-group">

<span class="input-group-text">

<i class="fa fa-search"></i>

</span>

<input

type="text"

name="cari"

class="form-control"

placeholder="Cari Nama atau NIS"

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
href="siswa.php"
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

</form>

<div class="card shadow">

<div class="card-body table-responsive">

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>No</th>

<th>NIS</th>

<th>Nama</th>

<th>JK</th>

<th>Kelas</th>

<th>Alamat</th>

<th width="250">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php if($total > 0){ ?>

<?php $no=1; ?>

<?php while($d=mysqli_fetch_assoc($query)){ ?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nis'] ?></td>

<td><?= $d['nama_siswa'] ?></td>

<td><?= $d['jk'] ?></td>

<td><?= $d['kelas'] ?></td>

<td><?= $d['alamat'] ?></td>

<td>

<div class="d-flex flex-wrap gap-2">

<a

href="edit_siswa.php?id=<?= $d['id_siswa']; ?>"

class="btn btn-warning btn-sm">

<i class="fa fa-pen"></i>

Edit

</a>

<a

href="#"

onclick="konfirmasi('hapus_siswa.php?id=<?= $d['id_siswa']; ?>')"

class="btn btn-danger btn-sm">

<i class="fa fa-trash"></i>

Hapus

</a>

<a

href="qr_siswa.php?id=<?= $d['id_siswa']; ?>"

class="btn btn-success btn-sm">

<i class="fa fa-qrcode"></i>

QR

</a>

<a

href="pdf_siswa.php?id=<?= $d['id_siswa']; ?>"

target="_blank"

class="btn btn-primary btn-sm">

<i class="fa fa-file-pdf"></i>

PDF

</a>

</div>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="7" class="text-center">
Belum ada data siswa.
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
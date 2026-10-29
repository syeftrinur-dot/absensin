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

$tanggal = isset($_GET['tanggal'])
    ? $_GET['tanggal']
    : date('Y-m-d');

$query = mysqli_query($koneksi,"
SELECT
    absensi.*,
    siswa.nama_siswa,
    siswa.nis,
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

$total = mysqli_num_rows($query);

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa fa-file-lines text-primary"></i>

Laporan Absensi

</h2>

<p class="text-muted">

Laporan kehadiran siswa berdasarkan tanggal.

</p>

</div>

<div class="col-lg-4 text-end">

<a
href="cetak_laporan.php?tanggal=<?= $tanggal ?>"
target="_blank"
class="btn btn-danger rounded-pill px-4">

<i class="fa fa-file-pdf"></i>

PDF

</a>

</div>

</div>

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="GET">

<div class="row g-3 align-items-end">

<div class="col-md-4">

<label class="form-label">

Pilih Tanggal

</label>

<input
type="date"
name="tanggal"
class="form-control"
value="<?= $tanggal ?>">

</div>

<div class="col-md-2 d-grid">

<button
class="btn btn-success">

<i class="fa fa-search"></i>

Tampilkan

</button>

</div>

<div class="col-md-2 d-grid">

<a
href="laporan.php"
class="btn btn-secondary">

<i class="fa fa-rotate"></i>

Refresh

</a>

</div>

<div class="col-md-4 text-end">

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
    id="laporanTable"
    class="table table-hover table-striped">

<thead class="table-primary">

<tr>

<th width="60">

No

</th>

<th>

NIS

</th>

<th>

Nama

</th>

<th>

Kelas

</th>

<th>

Mapel

</th>

<th>

Guru

</th>

<th>

Jam Masuk

</th>

<th>

Status

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

<td>

<?= $no++ ?>

</td>

<td>

<?= htmlspecialchars($d['nis']) ?>

</td>

<td>

<?= htmlspecialchars($d['nama_siswa']) ?>

</td>

<td>

<?= htmlspecialchars($d['nama_kelas']) ?>

</td>

<td>

<?= htmlspecialchars($d['nama_mapel']) ?>

</td>

<td>

<?= htmlspecialchars($d['nama_guru']) ?>

</td>

<td>

<?= substr($d['jam_masuk'],0,5) ?>

</td>

<td>

<?php

$status = strtolower(trim($d['status']));

if($status=="hadir"){

echo "<span class='badge bg-success'>Hadir</span>";

}elseif($status=="izin"){

echo "<span class='badge bg-warning text-dark'>Izin</span>";

}elseif($status=="sakit"){

echo "<span class='badge bg-info text-dark'>Sakit</span>";

}else{

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

<td
colspan="8"
class="text-center text-muted py-5">

<i class="fa fa-folder-open fa-3x mb-3"></i>

<br>

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

<script>

$(document).ready(function(){

    console.log(
        $('#laporanTable tbody tr').length
    );

});
</script>

<?php include "../layout/footer.php"; ?>
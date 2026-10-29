<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../config/koneksi.php";
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9;">

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3>Laporan Absensi</h3>
</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-4">
<label>Tanggal</label>

<input
type="date"
name="tanggal"
class="form-control"
value="<?= $tanggal ?>">
</div>

<div class="col-md-3 d-flex align-items-end">

<button class="btn btn-success">
Tampilkan
</button>
<a href="export_excel.php?tanggal=<?= $tanggal ?>" class="btn btn-success ms-2">
    📊 Export Excel
</a>
 <a href="cetak_pdf.php?tanggal=<?= $tanggal ?>" target="_blank" class="btn btn-danger ms-2">
    📄 Cetak PDF
</a>
</div>

</div>

</form>

<hr>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Mapel</th>
<th>Guru</th>
<th>Jam</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

$query=mysqli_query($koneksi,"

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

JOIN kelas
ON jadwal.id_kelas=kelas.id_kelas

JOIN mapel
ON jadwal.id_mapel=mapel.id_mapel

JOIN guru
ON jadwal.id_guru=guru.id_guru

WHERE absensi.tanggal='$tanggal'

ORDER BY jam_masuk ASC

");

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nis'] ?></td>

<td><?= $d['nama_siswa'] ?></td>

<td><?= $d['nama_kelas'] ?></td>

<td><?= $d['nama_mapel'] ?></td>

<td><?= $d['nama_guru'] ?></td>

<td><?= $d['jam_masuk'] ?></td>

<td>

<span class="badge bg-success">
<?= $d['status'] ?>
</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>
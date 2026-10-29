<?php

include "../config/koneksi.php";

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Absensi.xls");

$tanggal=$_GET['tanggal'];

$query=mysqli_query($koneksi,"
SELECT
absensi.*,
siswa.nama_siswa,
kelas.nama_kelas,
guru.nama_guru,
mapel.nama_mapel

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
");

?>

<table border="1">

<tr>

<th>No</th>

<th>Nama</th>

<th>Kelas</th>

<th>Mapel</th>

<th>Guru</th>

<th>Jam</th>

<th>Status</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nama_siswa'] ?></td>

<td><?= $d['nama_kelas'] ?></td>

<td><?= $d['nama_mapel'] ?></td>

<td><?= $d['nama_guru'] ?></td>

<td><?= $d['jam_masuk'] ?></td>

<td><?= $d['status'] ?></td>

</tr>

<?php } ?>

</table>
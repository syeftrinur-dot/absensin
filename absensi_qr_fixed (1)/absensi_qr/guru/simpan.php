<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != "guru") {
    exit("<div class='alert alert-danger'>Akses ditolak.</div>");
}

include "../koneksi.php";

/* =====================================
   VALIDASI
===================================== */

if (!isset($_POST['qr']) || !isset($_POST['id_jadwal'])) {

    exit("<div class='alert alert-danger'>
    Data tidak lengkap.
    </div>");

}

$qr = mysqli_real_escape_string($koneksi, trim($_POST['qr']));
$id_jadwal = intval($_POST['id_jadwal']);

/* =====================================
   CARI SISWA BERDASARKAN QR
===================================== */

$qSiswa = mysqli_query($koneksi, "
SELECT *
FROM siswa
WHERE qr_code='$qr'
");

if (mysqli_num_rows($qSiswa) == 0) {

    exit("
    <div class='alert alert-danger'>
        QR Code tidak terdaftar.
    </div>
    ");

}

$siswa = mysqli_fetch_assoc($qSiswa);

$id_siswa = $siswa['id_siswa'];

/* =====================================
   CEK ABSENSI HARI INI
===================================== */

$qCek = mysqli_query($koneksi,"
SELECT *
FROM absensi
WHERE id_siswa='$id_siswa'
AND id_jadwal='$id_jadwal'
AND tanggal=CURDATE()
");

if(mysqli_num_rows($qCek)>0){

    exit("
    <div class='alert alert-warning'>

        <h5>Sudah Absen</h5>

        <hr>

        <b>".$siswa['nama_siswa']."</b><br>

        NIS : ".$siswa['nis']."<br>

        Kelas : ".$siswa['kelas']."

    </div>
    ");

}

/* =====================================
   SIMPAN ABSENSI
===================================== */

$simpan = mysqli_query($koneksi,"
INSERT INTO absensi
(
id_siswa,
id_jadwal,
tanggal,
jam_masuk,
status
)
VALUES
(
'$id_siswa',
'$id_jadwal',
CURDATE(),
CURTIME(),
'Hadir'
)
");

if($simpan){

?>

<div class="alert alert-success">

<h5>

<i class="fa fa-check-circle"></i>

Absensi Berhasil

</h5>

<hr>

<table class="table table-borderless mb-0">

<tr>

<th width="90">NIS</th>

<td><?= htmlspecialchars($siswa['nis']) ?></td>

</tr>

<tr>

<th>Nama</th>

<td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>

</tr>

<tr>

<th>Kelas</th>

<td><?= htmlspecialchars($siswa['kelas']) ?></td>

</tr>

<tr>

<th>Status</th>

<td>

<span class="badge bg-success">

Hadir

</span>

</td>

</tr>

<tr>

<th>Jam</th>

<td><?= date("H:i:s") ?></td>

</tr>

</table>

</div>

<?php

}else{

?>

<div class="alert alert-danger">

Gagal menyimpan absensi.

<br><br>

<?= mysqli_error($koneksi); ?>

</div>

<?php

}

?>
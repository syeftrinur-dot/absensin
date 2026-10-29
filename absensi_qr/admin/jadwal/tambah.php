<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if(isset($_POST['simpan'])){

    $id_guru = $_POST['id_guru'];
    $id_kelas = $_POST['id_kelas'];
    $id_mapel = $_POST['id_mapel'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    mysqli_query($koneksi,"INSERT INTO jadwal
    (id_guru,id_kelas,id_mapel,hari,jam_mulai,jam_selesai)
    VALUES
    ('$id_guru','$id_kelas','$id_mapel','$hari','$jam_mulai','$jam_selesai')");

    header("Location: index.php");
    exit;
}

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>
<div class="container mt-4">

<div class="card shadow">

<div class="card-header">
<h3>Tambah Jadwal</h3>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Guru</label>

<select name="id_guru" class="form-control" required>

<option value="">-- Pilih Guru --</option>

<?php
$guru = mysqli_query($koneksi,"SELECT * FROM guru");
while($g=mysqli_fetch_assoc($guru)){
?>
<option value="<?= $g['id_guru']; ?>">
<?= $g['nama_guru']; ?>
</option>
<?php } ?>

</select>

</div>

<div class="mb-3">
<label>Kelas</label>

<select name="id_kelas" class="form-control" required>

<option value="">-- Pilih Kelas --</option>

<?php
$kelas = mysqli_query($koneksi,"SELECT * FROM kelas");
while($k=mysqli_fetch_assoc($kelas)){
?>
<option value="<?= $k['id_kelas']; ?>">
<?= $k['nama_kelas']; ?>
</option>
<?php } ?>

</select>

</div>

<div class="mb-3">
<label>Mata Pelajaran</label>

<select name="id_mapel" class="form-control" required>

<option value="">-- Pilih Mata Pelajaran --</option>

<?php
$mapel = mysqli_query($koneksi,"SELECT * FROM mapel");
while($m=mysqli_fetch_assoc($mapel)){
?>
<option value="<?= $m['id_mapel']; ?>">
<?= $m['nama_mapel']; ?>
</option>
<?php } ?>

</select>

</div>

<div class="mb-3">
<label>Hari</label>

<select name="hari" class="form-control">

<option>Senin</option>
<option>Selasa</option>
<option>Rabu</option>
<option>Kamis</option>
<option>Jumat</option>
<option>Sabtu</option>

</select>

</div>

<div class="mb-3">
<label>Jam Mulai</label>

<input
type="time"
name="jam_mulai"
class="form-control"
required>

</div>

<div class="mb-3">
<label>Jam Selesai</label>

<input
type="time"
name="jam_selesai"
class="form-control"
required>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

Simpan

</button>

<a
href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include "../../layout/footer.php"; ?>
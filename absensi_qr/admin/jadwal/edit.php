<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id_jadwal='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $id_guru = $_POST['id_guru'];
    $id_kelas = $_POST['id_kelas'];
    $id_mapel = $_POST['id_mapel'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    mysqli_query($koneksi, "UPDATE jadwal SET
        id_guru='$id_guru',
        id_kelas='$id_kelas',
        id_mapel='$id_mapel',
        hari='$hari',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai'
        WHERE id_jadwal='$id'
    ");

    header("Location: index.php");
    exit;
}

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header">
<h4>Edit Jadwal</h4>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Guru</label>
<select name="id_guru" class="form-control" required>

<?php
$guru = mysqli_query($koneksi,"SELECT * FROM guru");
while($g = mysqli_fetch_assoc($guru)){
?>
<option value="<?= $g['id_guru']; ?>"
<?= ($g['id_guru']==$d['id_guru']) ? 'selected' : ''; ?>>
<?= $g['nama_guru']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="mb-3">
<label>Kelas</label>
<select name="id_kelas" class="form-control" required>

<?php
$kelas = mysqli_query($koneksi,"SELECT * FROM kelas");
while($k = mysqli_fetch_assoc($kelas)){
?>
<option value="<?= $k['id_kelas']; ?>"
<?= ($k['id_kelas']==$d['id_kelas']) ? 'selected' : ''; ?>>
<?= $k['nama_kelas']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="mb-3">
<label>Mata Pelajaran</label>
<select name="id_mapel" class="form-control" required>

<?php
$mapel = mysqli_query($koneksi,"SELECT * FROM mapel");
while($m = mysqli_fetch_assoc($mapel)){
?>
<option value="<?= $m['id_mapel']; ?>"
<?= ($m['id_mapel']==$d['id_mapel']) ? 'selected' : ''; ?>>
<?= $m['nama_mapel']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="mb-3">
<label>Hari</label>

<select name="hari" class="form-control">

<?php
$hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

foreach($hari as $h){
?>

<option value="<?= $h; ?>"
<?= ($d['hari']==$h)?'selected':'';?>>

<?= $h; ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">
<label>Jam Mulai</label>
<input type="time"
name="jam_mulai"
class="form-control"
value="<?= $d['jam_mulai']; ?>">
</div>

<div class="mb-3">
<label>Jam Selesai</label>
<input type="time"
name="jam_selesai"
class="form-control"
value="<?= $d['jam_selesai']; ?>">
</div>

<button type="submit"
name="update"
class="btn btn-success">

Update

</button>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include "../../layout/footer.php"; ?>
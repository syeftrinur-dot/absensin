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

/* =====================================
   SIMPAN DATA
===================================== */

if(isset($_POST['simpan'])){

    $id_guru     = intval($_POST['id_guru']);
    $id_kelas    = intval($_POST['id_kelas']);
    $id_mapel    = intval($_POST['id_mapel']);
    $hari        = mysqli_real_escape_string($koneksi,$_POST['hari']);
    $jam_mulai   = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Cek bentrok jadwal kelas
    $cek = mysqli_query($koneksi,"
        SELECT *
        FROM jadwal
        WHERE id_kelas='$id_kelas'
        AND hari='$hari'
        AND (
            ('$jam_mulai' BETWEEN jam_mulai AND jam_selesai)
            OR
            ('$jam_selesai' BETWEEN jam_mulai AND jam_selesai)
        )
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
        alert('Jadwal bentrok dengan jadwal yang sudah ada.');
        window.history.back();
        </script>";

        exit;
    }

    mysqli_query($koneksi,"
    INSERT INTO jadwal
    (
        id_guru,
        id_kelas,
        id_mapel,
        hari,
        jam_mulai,
        jam_selesai
    )
    VALUES
    (
        '$id_guru',
        '$id_kelas',
        '$id_mapel',
        '$hari',
        '$jam_mulai',
        '$jam_selesai'
    )
    ");

    echo "<script>
    alert('Jadwal berhasil disimpan.');
    window.location='jadwal.php';
    </script>";

}

$guru = mysqli_query($koneksi,"
SELECT *
FROM guru
ORDER BY nama_guru
");

$kelas = mysqli_query($koneksi,"
SELECT *
FROM kelas
ORDER BY nama_kelas
");

$mapel = mysqli_query($koneksi,"
SELECT *
FROM mapel
ORDER BY nama_mapel
");

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa fa-calendar-plus text-primary"></i>

Tambah Jadwal

</h2>

<p class="text-muted">

Tambahkan jadwal pelajaran baru.

</p>

</div>

<div class="col-lg-4 text-end">

<a href="jadwal.php"
class="btn btn-secondary rounded-pill px-4">

<i class="fa fa-arrow-left"></i>

Kembali

</a>

</div>

</div>

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="POST">
<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Guru

</label>

<select
name="id_guru"
class="form-select"
required>

<option value="">-- Pilih Guru --</option>

<?php while($g=mysqli_fetch_assoc($guru)){ ?>

<option value="<?= $g['id_guru']; ?>">

<?= htmlspecialchars($g['nama_guru']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Kelas

</label>

<select
name="id_kelas"
class="form-select"
required>

<option value="">-- Pilih Kelas --</option>

<?php while($k=mysqli_fetch_assoc($kelas)){ ?>

<option value="<?= $k['id_kelas']; ?>">

<?= htmlspecialchars($k['nama_kelas']); ?>

</option>

<?php } ?>

</select>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Mata Pelajaran

</label>

<select
name="id_mapel"
class="form-select"
required>

<option value="">-- Pilih Mata Pelajaran --</option>

<?php while($m=mysqli_fetch_assoc($mapel)){ ?>

<option value="<?= $m['id_mapel']; ?>">

<?= htmlspecialchars($m['nama_mapel']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Hari

</label>

<select
name="hari"
class="form-select"
required>

<option>Senin</option>
<option>Selasa</option>
<option>Rabu</option>
<option>Kamis</option>
<option>Jumat</option>
<option>Sabtu</option>

</select>

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Jam Mulai

</label>

<input
type="time"
name="jam_mulai"
class="form-control"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label fw-semibold">

Jam Selesai

</label>

<input
type="time"
name="jam_selesai"
class="form-control"
required>

</div>

</div>

<hr>

<button
type="submit"
name="simpan"
class="btn btn-primary">

<i class="fa fa-save"></i>

Simpan

</button>

<a
href="jadwal.php"
class="btn btn-outline-secondary">

Batal

</a>

</form>

</div>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
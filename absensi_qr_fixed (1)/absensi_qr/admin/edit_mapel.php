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

if (!isset($_GET['id'])) {
    header("Location: mapel.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi,"
SELECT *
FROM mapel
WHERE id_mapel='$id'
");

if(mysqli_num_rows($query)==0){

    header("Location: mapel.php");
    exit;

}

$data = mysqli_fetch_assoc($query);

/* ===============================
   UPDATE
================================ */

if(isset($_POST['update'])){

    $kode = mysqli_real_escape_string($koneksi,$_POST['kode_mapel']);
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_mapel']);

    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM mapel
    WHERE kode_mapel='$kode'
    AND id_mapel!='$id'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>

        alert('Kode mata pelajaran sudah digunakan.');

        window.history.back();

        </script>";

        exit;

    }

    $update = mysqli_query($koneksi,"
    UPDATE mapel
    SET
        kode_mapel='$kode',
        nama_mapel='$nama'
    WHERE id_mapel='$id'
    ");

    if($update){

        echo "<script>

        alert('Data mata pelajaran berhasil diperbarui.');

        window.location='mapel.php';

        </script>";

        exit;

    }else{

        echo "<script>

        alert('Gagal memperbarui data.');

        </script>";

    }

}

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa-solid fa-book text-warning"></i>

Edit Mata Pelajaran

</h2>

<p class="text-muted">

Perbarui data mata pelajaran.

</p>

</div>

<div class="col-lg-4 text-end">

<a href="mapel.php"

class="btn btn-secondary rounded-pill px-4">

<i class="fa fa-arrow-left"></i>

Kembali

</a>

</div>

</div>

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="POST">

<div class="mb-3">

<label class="form-label fw-semibold">

Kode Mata Pelajaran

</label>

<input

type="text"

name="kode_mapel"

class="form-control"

value="<?= htmlspecialchars($data['kode_mapel']) ?>"

required>

</div>

<div class="mb-4">

<label class="form-label fw-semibold">

Nama Mata Pelajaran

</label>

<input

type="text"

name="nama_mapel"

class="form-control"

value="<?= htmlspecialchars($data['nama_mapel']) ?>"

required>

</div>

<hr>

<button

type="submit"

name="update"

class="btn btn-success">

<i class="fa fa-save"></i>

Simpan Perubahan

</button>

<a

href="mapel.php"

class="btn btn-outline-secondary">

Batal

</a>

</form>

</div>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
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

if(!isset($_GET['id'])){
    header("Location: siswa.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi,"
SELECT *
FROM siswa
WHERE id_siswa='$id'
");

if(mysqli_num_rows($query)==0){
    header("Location: siswa.php");
    exit;
}

$d = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nis        = mysqli_real_escape_string($koneksi,$_POST['nis']);
    $nama       = mysqli_real_escape_string($koneksi,$_POST['nama_siswa']);
    $jk         = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $kelas      = mysqli_real_escape_string($koneksi,$_POST['kelas']);
    $alamat     = mysqli_real_escape_string($koneksi,$_POST['alamat']);

    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM siswa
    WHERE nis='$nis'
    AND id_siswa!='$id'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
        alert('NIS sudah digunakan!');
        window.history.back();
        </script>";
        exit;
    }

    $update = mysqli_query($koneksi,"
    UPDATE siswa
    SET
        nis='$nis',
        nama_siswa='$nama',
        jk='$jk',
        kelas='$kelas',
        alamat='$alamat'
    WHERE id_siswa='$id'
    ");

    if($update){

        echo "<script>
        alert('Data siswa berhasil diupdate');
        window.location='siswa.php';
        </script>";

    }else{

        echo "<script>
        alert('Gagal mengupdate data');
        </script>";

    }

}

include "../layout/header.php";
include "../layout/sidebar.php";
?>
<div class="content">
<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>Edit Data Siswa</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>NIS</label>

<input
type="text"
name="nis"
class="form-control"
value="<?= $d['nis']; ?>"
required>

</div>

<div class="mb-3">

<label>Nama Siswa</label>

<input
type="text"
name="nama_siswa"
class="form-control"
value="<?= $d['nama_siswa']; ?>"
required>

</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select
name="jk"
class="form-control"
required>

<option value="L" <?= ($d['jk']=="L") ? "selected" : "" ?>>
Laki-laki
</option>

<option value="P" <?= ($d['jk']=="P") ? "selected" : "" ?>>
Perempuan
</option>

</select>

</div>

<div class="mb-3">

<label>Kelas</label>

<input
type="text"
name="kelas"
class="form-control"
value="<?= $d['kelas']; ?>"
required>

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
rows="4"
class="form-control"><?= $d['alamat']; ?></textarea>

</div>

<button
type="submit"
name="update"
class="btn btn-success">

<i class="fa fa-save"></i>

Update

</button>

<a
href="siswa.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
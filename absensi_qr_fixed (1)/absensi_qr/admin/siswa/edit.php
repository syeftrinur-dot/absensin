<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if(!isset($_GET['id'])){
    die("ID tidak ditemukan.");
}

$id = (int)$_GET['id'];

$data = mysqli_query($koneksi,"SELECT * FROM siswa WHERE id_siswa='$id'");

if(mysqli_num_rows($data)==0){
    die("Data siswa tidak ditemukan.");
}

$siswa = mysqli_fetch_assoc($data);

if(isset($_POST['simpan'])){

    $nis = mysqli_real_escape_string($koneksi,$_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_siswa']);
    $jk = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $kelas = mysqli_real_escape_string($koneksi,$_POST['kelas']);
    $alamat = mysqli_real_escape_string($koneksi,$_POST['alamat']);

    $update = mysqli_query($koneksi,"
    UPDATE siswa SET
        nis='$nis',
        nama_siswa='$nama',
        jk='$jk',
        kelas='$kelas',
        alamat='$alamat'
    WHERE id_siswa='$id'
    ");

    if($update){
        echo "<script>
                alert('Data berhasil diubah');
                window.location='index.php';
              </script>";
        exit;
    }else{
        echo "<div class='alert alert-danger'>Gagal mengubah data.</div>";
    }
}

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning">
    <h4>Edit Data Siswa</h4>
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>NIS</label>
<input type="text" name="nis" class="form-control"
value="<?= $siswa['nis']; ?>" required>
</div>

<div class="mb-3">
<label>Nama Siswa</label>
<input type="text" name="nama_siswa" class="form-control"
value="<?= $siswa['nama_siswa']; ?>" required>
</div>

<div class="mb-3">
<label>Jenis Kelamin</label>
<select name="jk" class="form-control">

<option value="L" <?= $siswa['jk']=="L"?"selected":""; ?>>Laki-laki</option>

<option value="P" <?= $siswa['jk']=="P"?"selected":""; ?>>Perempuan</option>

</select>
</div>

<div class="mb-3">
<label>Kelas</label>
<input type="text" name="kelas"
class="form-control"
value="<?= $siswa['kelas']; ?>" required>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat"
class="form-control"><?= $siswa['alamat']; ?></textarea>
</div>

<button type="submit"
name="simpan"
class="btn btn-primary">
Simpan
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
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
if(isset($_POST['simpan'])){

    $nis        = mysqli_real_escape_string($koneksi,$_POST['nis']);
    $nama       = mysqli_real_escape_string($koneksi,$_POST['nama_siswa']);
    $jk         = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $kelas      = mysqli_real_escape_string($koneksi,$_POST['kelas']);
    $alamat     = mysqli_real_escape_string($koneksi,$_POST['alamat']);

    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM siswa
    WHERE nis='$nis'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
        alert('NIS sudah digunakan');
        window.history.back();
        </script>";

        exit;
    }

    $simpan=mysqli_query($koneksi,"
    INSERT INTO siswa
    (
        nis,
        nama_siswa,
        jk,
        kelas,
        alamat
    )
    VALUES
    (
        '$nis',
        '$nama',
        '$jk',
        '$kelas',
        '$alamat'
    )
    ");

    if($simpan){

        echo "<script>
        alert('Data siswa berhasil ditambahkan');
        window.location='siswa.php';
        </script>";

    }else{

        echo "<script>
        alert('Gagal menyimpan data');
        </script>";

    }

}
require_once "../koneksi.php";
include "../layout/header.php";
include "../layout/sidebar.php";
?>
<div class = "content">
<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>Tambah Data Siswa</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>NIS</label>

<input
type="text"
name="nis"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Nama Siswa</label>

<input
type="text"
name="nama_siswa"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select
name="jk"
class="form-control"
required>

<option value="">-- Pilih --</option>

<option value="L">Laki-laki</option>

<option value="P">Perempuan</option>

</select>

</div>

<div class="mb-3">

<label>Kelas</label>

<input
type="text"
name="kelas"
class="form-control"
placeholder="Contoh : VII A"
required>

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"
rows="4"></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

<i class="fa fa-save"></i>

Simpan

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
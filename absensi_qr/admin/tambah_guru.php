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

if(isset($_POST['simpan'])){

    $nip        = mysqli_real_escape_string($koneksi,$_POST['nip']);
    $nama_guru  = mysqli_real_escape_string($koneksi,$_POST['nama_guru']);
    $jk         = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $no_hp      = mysqli_real_escape_string($koneksi,$_POST['no_hp']);
    $alamat     = mysqli_real_escape_string($koneksi,$_POST['alamat']);

    // Cek NIP
    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM guru
    WHERE nip='$nip'
    ");

    if(mysqli_num_rows($cek)>0){
header("Location: guru.php?success=tambah");
exit;
        exit;
    }

    $simpan = mysqli_query($koneksi,"
    INSERT INTO guru
    (
        nip,
        nama_guru,
        jk,
        no_hp,
        alamat
    )
    VALUES
    (
        '$nip',
        '$nama_guru',
        '$jk',
        '$no_hp',
        '$alamat'
    )
    ");

    if($simpan){

header("Location: guru.php?success=tambah");
exit;

    }else{

        echo "<script>
        alert('Gagal menambahkan data');
        </script>";

    }

}

include "../layout/header.php";
include "../layout/sidebar.php";
?>
<style>
label,
.card-header,
.card-title,
h1,h2,h3,h4,h5,
p{
    color:#212529 !important;
}
</style>
<div class="content">
<div class="container-fluid">
</div>
<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>Tambah Data Guru</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>NIP</label>

<input
type="text"
name="nip"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Nama Guru</label>

<input
type="text"
name="nama_guru"
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

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control">

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
rows="4"
class="form-control"></textarea>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

<i class="fa fa-save"></i>

Simpan

</button>

<a
href="guru.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
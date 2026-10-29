<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $nip = $_POST['nip'];
    $nama = $_POST['nama_kelas'];
    $jk = $_POST['jk'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "INSERT INTO kelas
    (nip, nama_kelas, jk, no_hp, alamat)
    VALUES
    ('$nip','$nama','$jk','$no_hp','$alamat')");

    if ($query) {
        echo "<script>
                alert('Data kelas Berhasil Disimpan');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>alert('Gagal Menyimpan Data');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Tambah kelas</h2>

<form method="POST">

<div class="mb-3">
<label>NIP</label>
<input type="text" name="nip" class="form-control" required>
</div>

<div class="mb-3">
<label>Nama kelas</label>
<input type="text" name="nama_kelas" class="form-control" required>
</div>

<div class="mb-3">
<label>Jenis Kelamin</label>

<select name="jk" class="form-control">
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
</select>

</div>

<div class="mb-3">
<label>No HP</label>
<input type="text" name="no_hp" class="form-control">
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control"></textarea>
</div>

<button class="btn btn-success" name="simpan">
Simpan
</button>

<a href="index.php" class="btn btn-secondary">
Kembali
</a>

</form>

</body>
</html>
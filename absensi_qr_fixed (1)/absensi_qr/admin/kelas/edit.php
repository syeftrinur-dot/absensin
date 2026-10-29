<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nip = $_POST['nip'];
    $nama = $_POST['nama_kelas'];
    $jk = $_POST['jk'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi,"UPDATE kelas SET
        nip='$nip',
        nama_kelas='$nama',
        jk='$jk',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE id_kelas='$id'");

    echo "<script>
        alert('Data berhasil diubah');
        window.location='index.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Edit kelas</h2>

<form method="POST">

<label>NIP</label>
<input type="text" name="nip" class="form-control mb-3" value="<?= $row['nip']; ?>">

<label>Nama kelas</label>
<input type="text" name="nama_guru" class="form-control mb-3" value="<?= $row['nama_kelas']; ?>">

<label>Jenis Kelamin</label>
<select name="jk" class="form-control mb-3">
    <option value="L" <?= ($row['jk']=='L')?'selected':''; ?>>Laki-laki</option>
    <option value="P" <?= ($row['jk']=='P')?'selected':''; ?>>Perempuan</option>
</select>

<label>No HP</label>
<input type="text" name="no_hp" class="form-control mb-3" value="<?= $row['no_hp']; ?>">

<label>Alamat</label>
<textarea name="alamat" class="form-control mb-3"><?= $row['alamat']; ?></textarea>

<button type="submit" name="update" class="btn btn-primary">
Update
</button>

<a href="index.php" class="btn btn-secondary">
Kembali
</a>

</form>

</body>
</html>
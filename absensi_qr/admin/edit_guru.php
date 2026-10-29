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
    header("Location: guru.php");
    exit;
}

$id = intval($_GET['id']);

$data = mysqli_query($koneksi,"
SELECT *
FROM guru
WHERE id_guru='$id'
");

if(mysqli_num_rows($data)==0){
    header("Location: guru.php");
    exit;
}

$d = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nip       = mysqli_real_escape_string($koneksi,$_POST['nip']);
    $nama      = mysqli_real_escape_string($koneksi,$_POST['nama_guru']);
    $jk        = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $no_hp     = mysqli_real_escape_string($koneksi,$_POST['no_hp']);
    $alamat    = mysqli_real_escape_string($koneksi,$_POST['alamat']);

    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM guru
    WHERE nip='$nip'
    AND id_guru!='$id'
    ");

    if(mysqli_num_rows($cek)>0){
header("Location: guru.php?success=tambah");
exit;
    }

    $update = mysqli_query($koneksi,"
    UPDATE guru
    SET

    nip='$nip',
    nama_guru='$nama',
    jk='$jk',
    no_hp='$no_hp',
    alamat='$alamat'

    WHERE id_guru='$id'
    ");

    if($update){

header("Location: guru.php?success=tambah");
exit;

    }else{

        echo "<script>
        alert('Gagal memperbarui data');
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

<h4>Edit Data Guru</h4>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>NIP</label>

<input
type="text"
name="nip"
class="form-control"
value="<?= $d['nip']; ?>"
required>

</div>

<div class="mb-3">

<label>Nama Guru</label>

<input
type="text"
name="nama_guru"
class="form-control"
value="<?= $d['nama_guru']; ?>"
required>

</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select
name="jk"
class="form-control"
required>

<option value="L"
<?= $d['jk']=="L" ? "selected" : "" ?>>

Laki-laki

</option>

<option value="P"
<?= $d['jk']=="P" ? "selected" : "" ?>>

Perempuan

</option>

</select>

</div>

<div class="mb-3">

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= $d['no_hp']; ?>">

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
href="guru.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
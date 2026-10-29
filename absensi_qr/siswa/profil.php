<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";

include "layout/header.php";
include "layout/sidebar.php";

$idSiswa=$_SESSION['id_siswa'];

$query=mysqli_query($koneksi,"
SELECT *
FROM siswa
WHERE id_siswa='$idSiswa'
");

$data=mysqli_fetch_assoc($query);

?>

<div class="content">

<div class="container-fluid">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow">

<div class="card-header">

<h4>

<i class="fa-solid fa-user"></i>

Profil Saya

</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 text-center">

<?php

if(!empty($data['foto']) && file_exists("../assets/img/siswa/".$data['foto'])){

?>

<img

src="../assets/img/siswa/<?= $data['foto'] ?>"

class="img-fluid rounded-circle border"

style="width:200px;height:200px;object-fit:cover;">

<?php

}else{

?>

<img

src="../assets/img/default-user.png"

class="img-fluid rounded-circle border"

style="width:200px;height:200px;object-fit:cover;">

<?php

}

?>

<br><br>

<form

action="upload_foto.php"

method="POST"

enctype="multipart/form-data">

<input

type="file"

name="foto"

class="form-control"

accept=".jpg,.jpeg,.png"

required>

<br>

<button

class="btn btn-primary w-100">

<i class="fa fa-upload"></i>

Tambah / Ubah Foto

</button>

</form>

</div>

<div class="col-md-8">

<form action="update_profil.php" method="POST">

<div class="mb-3">

<label class="form-label">

NIS

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($data['nis']) ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="nama_siswa"
class="form-control"
value="<?= htmlspecialchars($data['nama_siswa']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Kelas

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($data['kelas']) ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">

Alamat

</label>

<textarea
name="alamat"
class="form-control"
rows="4"><?= htmlspecialchars($data['alamat']) ?></textarea>

</div>

<button class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Perubahan

</button>

</form>
<tr>

<th>

Nama

</th>

<td>

<?= htmlspecialchars($data['nama_siswa']) ?>

</td>

</tr>

<tr>

<th>

Kelas

</th>

<td>

<?= htmlspecialchars($data['kelas']) ?>

</td>

</tr>

<tr>

<th>

Alamat

</th>

<td>

<?= htmlspecialchars($data['alamat']) ?>

</td>

</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>
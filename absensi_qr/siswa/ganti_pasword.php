<?php

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";
include "layout/header.php";
include "layout/sidebar.php";

?>

<div class="content">

<div class="container-fluid">

<div class="row justify-content-center">

<div class="col-lg-6">

<div class="card">

<div class="card-header">

<h4>

<i class="fa-solid fa-key"></i>

Ganti Password

</h4>

</div>

<div class="card-body">

<form action="proses_password.php" method="POST">

<div class="mb-3">

<label class="form-label">

Password Lama

</label>

<input
type="password"
name="password_lama"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password Baru

</label>

<input
type="password"
name="password_baru"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Konfirmasi Password

</label>

<input
type="password"
name="konfirmasi"
class="form-control"
required>

</div>

<button class="btn btn-primary">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Password

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>
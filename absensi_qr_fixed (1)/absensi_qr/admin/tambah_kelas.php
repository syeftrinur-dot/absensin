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

    $kode = mysqli_real_escape_string($koneksi,$_POST['kode_kelas']);
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_kelas']);
    $wali = mysqli_real_escape_string($koneksi,$_POST['wali_kelas']);

    // Cek kode kelas
    $cek = mysqli_query($koneksi,"
        SELECT *
        FROM kelas
        WHERE kode_kelas='$kode'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
            alert('Kode kelas sudah digunakan!');
            window.history.back();
        </script>";
        exit;
    }

    $simpan = mysqli_query($koneksi,"
        INSERT INTO kelas(
            kode_kelas,
            nama_kelas,
            wali_kelas
        )
        VALUES(
            '$kode',
            '$nama',
            '$wali'
        )
    ");

    if($simpan){

        echo "<script>
            alert('Data kelas berhasil disimpan');
            window.location='kelas.php';
        </script>";

        exit;

    }else{

        echo "<script>
            alert('Gagal menyimpan data');
        </script>";

    }

}

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid"><div class="row mb-4">

    <div class="col-lg-8">

        <h2 class="fw-bold">

            <i class="fa-solid fa-plus text-primary"></i>

            Tambah Data Kelas

        </h2>

        <p class="text-muted">

            Tambahkan data kelas baru ke dalam sistem.

        </p>

    </div>

    <div class="col-lg-4 text-end">

        <a href="kelas.php"

        class="btn btn-secondary rounded-pill px-4">

            <i class="fa fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Kode Kelas

</label>

<input
type="text"
name="kode_kelas"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Kelas

</label>

<input
type="text"
name="nama_kelas"
class="form-control"
required>

</div>

</div>

<div class="mb-4">

<label class="form-label">

Wali Kelas

</label>

<input
type="text"
name="wali_kelas"
class="form-control">

</div>

<hr>

<button
type="submit"
name="simpan"
class="btn btn-primary">

<i class="fa fa-save"></i>

Simpan

</button>

<a
href="kelas.php"
class="btn btn-outline-secondary">

Batal

</a>

</form>

</div>

</div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
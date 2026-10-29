<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if(isset($_POST['simpan'])){

    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];

    mysqli_query($koneksi,"INSERT INTO mapel(kode_mapel,nama_mapel)
                        VALUES('$kode_mapel','$nama_mapel')");

    header("Location: index.php");
    exit;
}

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">
            <h3>Tambah Mata Pelajaran</h3>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Kode Mata Pelajaran</label>
                    <input type="text"
                           name="kode_mapel"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text"
                           name="nama_mapel"
                           class="form-control"
                           required>
                </div>

                <button type="submit"
                        name="simpan"
                        class="btn btn-success">
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
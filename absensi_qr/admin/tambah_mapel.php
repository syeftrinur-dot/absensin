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

/* ===============================
   SIMPAN DATA
================================ */

if(isset($_POST['simpan'])){

    $kode = mysqli_real_escape_string($koneksi,$_POST['kode_mapel']);
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_mapel']);

    // Cek kode mapel
    $cek = mysqli_query($koneksi,"
        SELECT *
        FROM mapel
        WHERE kode_mapel='$kode'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
            alert('Kode mata pelajaran sudah digunakan.');
            window.history.back();
        </script>";
        exit;
    }

    $simpan = mysqli_query($koneksi,"
        INSERT INTO mapel(
            kode_mapel,
            nama_mapel
        )
        VALUES(
            '$kode',
            '$nama'
        )
    ");

    if($simpan){

        echo "<script>
            alert('Data mata pelajaran berhasil disimpan.');
            window.location='mapel.php';
        </script>";
        exit;

    }else{

        echo "<script>
            alert('Gagal menyimpan data.');
        </script>";

    }

}

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-lg-8">

            <h2 class="fw-bold">

                <i class="fa-solid fa-book-medical text-primary"></i>

                Tambah Mata Pelajaran

            </h2>

            <p class="text-muted">

                Tambahkan data mata pelajaran baru ke dalam sistem.

            </p>

        </div>

        <div class="col-lg-4 text-end">

            <a href="mapel.php"
               class="btn btn-secondary rounded-pill px-4">

                <i class="fa fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Kode Mata Pelajaran

                    </label>

                    <input
                        type="text"
                        name="kode_mapel"
                        class="form-control"
                        placeholder="Contoh : MTK01"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Mata Pelajaran

                    </label>

                    <input
                        type="text"
                        name="nama_mapel"
                        class="form-control"
                        placeholder="Contoh : Matematika"
                        required>

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
                    href="mapel.php"
                    class="btn btn-outline-secondary">

                    Batal

                </a>

            </form>

        </div>

    </div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
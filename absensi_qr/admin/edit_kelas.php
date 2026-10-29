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

if (!isset($_GET['id'])) {
    header("Location: kelas.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi,"
SELECT *
FROM kelas
WHERE id_kelas='$id'
");

if(mysqli_num_rows($query)==0){

    header("Location: kelas.php");
    exit;

}

$data = mysqli_fetch_assoc($query);

/* ===============================
   UPDATE
================================ */

if(isset($_POST['update'])){

    $kode = mysqli_real_escape_string($koneksi,$_POST['kode_kelas']);
    $nama = mysqli_real_escape_string($koneksi,$_POST['nama_kelas']);
    $wali = mysqli_real_escape_string($koneksi,$_POST['wali_kelas']);

    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM kelas
    WHERE kode_kelas='$kode'
    AND id_kelas!='$id'
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>

        alert('Kode kelas sudah digunakan.');

        window.history.back();

        </script>";

        exit;

    }

    $update = mysqli_query($koneksi,"
    UPDATE kelas
    SET
        kode_kelas='$kode',
        nama_kelas='$nama',
        wali_kelas='$wali'
    WHERE id_kelas='$id'
    ");

    if($update){

        echo "<script>

        alert('Data kelas berhasil diperbarui.');

        window.location='kelas.php';

        </script>";

        exit;

    }else{

        echo "<script>

        alert('Gagal memperbarui data.');

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

                <i class="fa-solid fa-school text-warning"></i>

                Edit Data Kelas

            </h2>

            <p class="text-muted">

                Perbarui informasi kelas pada sistem.

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

                        <label class="form-label fw-semibold">

                            Kode Kelas

                        </label>

                        <input
                            type="text"
                            name="kode_kelas"
                            class="form-control"
                            value="<?= htmlspecialchars($data['kode_kelas']) ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">

                            Nama Kelas

                        </label>

                        <input
                            type="text"
                            name="nama_kelas"
                            class="form-control"
                            value="<?= htmlspecialchars($data['nama_kelas']) ?>"
                            required>

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Wali Kelas

                    </label>

                    <input
                        type="text"
                        name="wali_kelas"
                        class="form-control"
                        value="<?= htmlspecialchars($data['wali_kelas']) ?>">

                </div>

                <hr>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        name="update"
                        class="btn btn-success px-4">

                        <i class="fa fa-save"></i>

                        Simpan Perubahan

                    </button>

                    <a
                        href="kelas.php"
                        class="btn btn-outline-secondary px-4">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

<?php include "../layout/footer.php"; ?>
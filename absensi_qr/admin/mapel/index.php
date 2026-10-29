<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>

<!-- Judul Halaman -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Mata Pelajaran</h2>

    <a href="tambah.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Mata Pelajaran
    </a>
</div>

<!-- Tabel Data -->
<div class="card shadow">
    <div class="card-body">

        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Kode Mapel</th>
                    <th>Nama Mata Pelajaran</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM mapel");

            while($row = mysqli_fetch_assoc($data)){
            ?>

            <tr>

                <td><?= $no++ ?></td>
                <td><?= $row['kode_mapel'] ?></td>
                <td><?= $row['nama_mapel'] ?></td>

                <td>

                    <a href="edit.php?id=<?= $row['id_mapel'] ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="hapus.php?id=<?= $row['id_mapel'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Hapus
                    </a>

                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>
</div>

<?php include "../../layout/footer.php"; ?>
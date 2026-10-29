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
    <h2>Data Guru</h2>

    <a href="tambah.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Guru
    </a>
</div>

<!-- Tabel Data Guru -->
<div class="card shadow">
    <div class="card-body">

        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>JK</th>
                    <th>No HP</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM guru");

            while($row = mysqli_fetch_assoc($data)){
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nip'] ?></td>
                <td><?= $row['nama_guru'] ?></td>
                <td><?= $row['jk'] ?></td>
                <td><?= $row['no_hp'] ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['id_guru'] ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="hapus.php?id=<?= $row['id_guru'] ?>"
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
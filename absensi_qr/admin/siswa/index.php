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
    <h2>Data Siswa</h2>

    <a href="tambah.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Siswa
    </a>
</div>

<!-- Tabel Data -->
<div class="card shadow">
    <div class="card-body">

        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>JK</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th width="250">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM siswa");

            while($row = mysqli_fetch_assoc($data)){
            ?>

            <tr>

                <td><?= $no++ ?></td>
                <td><?= $row['nis'] ?></td>
                <td><?= $row['nama_siswa'] ?></td>
                <td><?= $row['jk'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td><?= $row['alamat'] ?></td>

                <td>

                    <a href="qr.php?id=<?= $row['id_siswa']; ?>" class="btn btn-info btn-sm">
                        QR Code
                    </a>

                    <a href="edit.php?id=<?= $row['id_siswa']; ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="hapus.php?id=<?= $row['id_siswa']; ?>"
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
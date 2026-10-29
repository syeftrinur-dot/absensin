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

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Kelas</h2>

    <a href="tambah.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Kelas
    </a>
</div>

<div class="card shadow">
    <div class="card-body">

        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th width="60">No</th>
                    <th>Nama Kelas</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php

            $no = 1;

            $data = mysqli_query($koneksi,"SELECT * FROM kelas ORDER BY nama_kelas ASC");

            while($row=mysqli_fetch_assoc($data)){

            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $row['nama_kelas']; ?></td>

                    <td>

                        <a href="edit.php?id=<?= $row['id_kelas']; ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="hapus.php?id=<?= $row['id_kelas']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus data?')">

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
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

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Jadwal</h4>
            <a href="tambah.php" class="btn btn-primary">
                + Tambah Jadwal
            </a>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;

                $query = mysqli_query($koneksi,"
                    SELECT
                        jadwal.*,
                        guru.nama_guru,
                        kelas.nama_kelas,
                        mapel.nama_mapel
                    FROM jadwal
                    JOIN guru
                        ON jadwal.id_guru = guru.id_guru
                    JOIN kelas
                        ON jadwal.id_kelas = kelas.id_kelas
                    JOIN mapel
                        ON jadwal.id_mapel = mapel.id_mapel
                    ORDER BY hari ASC, jam_mulai ASC
                ");

                while($data = mysqli_fetch_assoc($query)){
                ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['nama_guru']; ?></td>
                        <td><?= $data['nama_kelas']; ?></td>
                        <td><?= $data['nama_mapel']; ?></td>
                        <td><?= $data['hari']; ?></td>
                        <td><?= $data['jam_mulai']; ?> - <?= $data['jam_selesai']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $data['id_jadwal']; ?>" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <a href="hapus.php?id=<?= $data['id_jadwal']; ?>"
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

</div>

<?php include "../../layout/footer.php"; ?>
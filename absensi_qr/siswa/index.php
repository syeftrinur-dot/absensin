<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != "siswa") {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";

$idSiswa = $_SESSION['id_siswa'];

$querySiswa = mysqli_query($koneksi, "
    SELECT *
    FROM siswa
    WHERE id_siswa='$idSiswa'
    LIMIT 1
");

if (mysqli_num_rows($querySiswa) == 0) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$siswa = mysqli_fetch_assoc($querySiswa);

include "layout/header.php";
include "layout/sidebar.php";

/* ===========================
   TOTAL HADIR
=========================== */
$qHadir = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM absensi
    WHERE id_siswa='$idSiswa'
    AND status='Hadir'
");
$totalHadir = mysqli_fetch_assoc($qHadir)['total'];

/* ===========================
   TOTAL IZIN
=========================== */
$qIzin = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM absensi
    WHERE id_siswa='$idSiswa'
    AND status='Izin'
");
$totalIzin = mysqli_fetch_assoc($qIzin)['total'];

/* ===========================
   TOTAL SAKIT
=========================== */
$qSakit = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM absensi
    WHERE id_siswa='$idSiswa'
    AND status='Sakit'
");
$totalSakit = mysqli_fetch_assoc($qSakit)['total'];

/* ===========================
   TOTAL ALPHA
=========================== */
$qAlpha = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM absensi
    WHERE id_siswa='$idSiswa'
    AND status='Alpha'
");
$totalAlpha = mysqli_fetch_assoc($qAlpha)['total'];

$totalAbsen = $totalHadir + $totalIzin + $totalSakit + $totalAlpha;

$persentase = 0;

if ($totalAbsen > 0) {
    $persentase = round(($totalHadir / $totalAbsen) * 100);
}
?>

<div class="content">
    <div class="container-fluid">

        <div class="row mb-4">
            <div class="col-lg-8">
                <h2 class="fw-bold">Dashboard Siswa</h2>
                <p class="text-secondary">
                    Selamat datang, <b><?= htmlspecialchars($siswa['nama_siswa']); ?></b>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge bg-primary fs-6">
                    <?= date('d-m-Y'); ?>
                </span>
            </div>
        </div>

        <!-- ===========================
             KARTU DASHBOARD
        =========================== -->
        <div class="row g-4 mb-4">

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card success">
                    <div class="dashboard-title">Total Hadir</div>
                    <div class="dashboard-number"><?= $totalHadir ?></div>
                    <div class="dashboard-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card warning">
                    <div class="dashboard-title">Total Izin</div>
                    <div class="dashboard-number"><?= $totalIzin ?></div>
                    <div class="dashboard-icon">
                        <i class="fa-solid fa-envelope-open"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card danger">
                    <div class="dashboard-title">Alpha</div>
                    <div class="dashboard-number"><?= $totalAlpha ?></div>
                    <div class="dashboard-icon">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card info">
                    <div class="dashboard-title">Kehadiran</div>
                    <div class="dashboard-number"><?= $persentase ?>%</div>
                    <div class="progress mt-3">
                        <div
                            class="progress-bar bg-light"
                            role="progressbar"
                            style="width: <?= $persentase ?>%;">
                        </div>
                    </div>
                    <div class="dashboard-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>

        </div>

        <?php
        $qRiwayat = mysqli_query($koneksi, "
            SELECT
                absensi.*,
                mapel.nama_mapel,
                guru.nama_guru
            FROM absensi
            INNER JOIN jadwal ON absensi.id_jadwal = jadwal.id_jadwal
            INNER JOIN mapel ON jadwal.id_mapel = mapel.id_mapel
            INNER JOIN guru ON jadwal.id_guru = guru.id_guru
            WHERE absensi.id_siswa='$idSiswa'
            ORDER BY absensi.tanggal DESC, absensi.jam_masuk DESC
            LIMIT 5
        ");
        ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                    Riwayat Absensi Terbaru
                </div>
                <a href="riwayat.php" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-eye"></i>
                    Lihat Semua
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Mapel</th>
                                <th>Guru</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($qRiwayat) > 0): ?>
                                <?php while ($r = mysqli_fetch_assoc($qRiwayat)): ?>
                                    <tr>
                                        <td><?= date('d-m-Y', strtotime($r['tanggal'])) ?></td>
                                        <td><?= htmlspecialchars($r['nama_mapel']) ?></td>
                                        <td><?= htmlspecialchars($r['nama_guru']) ?></td>
                                        <td><?= substr($r['jam_masuk'], 0, 5) ?></td>
                                        <td>
                                            <?php
                                            switch (strtolower($r['status'])) {
                                                case "hadir":
                                                    echo "<span class='badge bg-success'>Hadir</span>";
                                                    break;
                                                case "izin":
                                                    echo "<span class='badge bg-warning text-dark'>Izin</span>";
                                                    break;
                                                case "sakit":
                                                    echo "<span class='badge bg-info text-dark'>Sakit</span>";
                                                    break;
                                                default:
                                                    echo "<span class='badge bg-danger'>Alpha</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2"></i>
                                        <br>
                                        Belum ada data absensi.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "layout/footer.php"; ?>

<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

include "../../layout/header.php";
include "../../layout/sidebar.php";

$jadwal = mysqli_query($koneksi,"
SELECT
    jadwal.id_jadwal,
    mapel.nama_mapel,
    kelas.nama_kelas,
    guru.nama_guru,
    jadwal.hari,
    jadwal.jam_mulai,
    jadwal.jam_selesai
FROM jadwal
JOIN guru ON guru.id_guru=jadwal.id_guru
JOIN kelas ON kelas.id_kelas=jadwal.id_kelas
JOIN mapel ON mapel.id_mapel=jadwal.id_mapel
ORDER BY jadwal.hari,jadwal.jam_mulai
");
?>

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2 class="fw-bold">
                <i class="bi bi-qr-code-scan"></i>
                Absensi QR Code
            </h2>

            <p class="text-muted">
                Pilih jadwal kemudian lakukan scan QR Code siswa.
            </p>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-5">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        <i class="bi bi-calendar-week"></i>
                        Pilih Jadwal
                    </h5>

                </div>

                <div class="card-body">

                    <form action="scan.php" method="GET">

                        <div class="mb-3">

                            <label class="form-label">
                                Jadwal
                            </label>

                            <select
                                name="id_jadwal"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Jadwal --
                                </option>

                                <?php while($j=mysqli_fetch_assoc($jadwal)){ ?>

                                <option value="<?= $j['id_jadwal']; ?>">

                                    <?= $j['hari']; ?>

                                    |

                                    <?= $j['jam_mulai']; ?>

                                    -

                                    <?= $j['jam_selesai']; ?>

                                    |

                                    <?= $j['nama_mapel']; ?>

                                    |

                                    <?= $j['nama_kelas']; ?>

                                    |

                                    <?= $j['nama_guru']; ?>

                                </option>

                                <?php } ?>

                            </select>

                        </div>

                        <button
                            class="btn btn-success w-100">

                            <i class="bi bi-camera"></i>

                            Mulai Scan QR

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-7">

            <div class="card shadow border-0">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">

                        <i class="bi bi-info-circle"></i>

                        Petunjuk

                    </h5>

                </div>

                <div class="card-body">

                    <ol>

                        <li>Pilih jadwal terlebih dahulu.</li>

                        <li>Klik <b>Mulai Scan QR</b>.</li>

                        <li>Izinkan akses kamera.</li>

                        <li>Arahkan QR Code siswa ke kamera.</li>

                        <li>Data absensi akan tersimpan otomatis.</li>

                    </ol>

                    <hr>

                    <div class="alert alert-info mb-0">

                        <i class="bi bi-lightbulb"></i>

                        Pastikan QR Code siswa jelas dan kamera memiliki pencahayaan yang cukup.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../layout/footer.php"; ?>
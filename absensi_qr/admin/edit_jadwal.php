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

if(!isset($_GET['id'])){
    header("Location: jadwal.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi,"
SELECT *
FROM jadwal
WHERE id_jadwal='$id'
");

if(mysqli_num_rows($query)==0){
    header("Location: jadwal.php");
    exit;
}

$data = mysqli_fetch_assoc($query);

$guru = mysqli_query($koneksi,"SELECT * FROM guru ORDER BY nama_guru");
$kelas = mysqli_query($koneksi,"SELECT * FROM kelas ORDER BY nama_kelas");
$mapel = mysqli_query($koneksi,"SELECT * FROM mapel ORDER BY nama_mapel");

if(isset($_POST['update'])){

    $id_guru = intval($_POST['id_guru']);
    $id_kelas = intval($_POST['id_kelas']);
    $id_mapel = intval($_POST['id_mapel']);
    $hari = mysqli_real_escape_string($koneksi,$_POST['hari']);
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Cek bentrok jadwal
    $cek = mysqli_query($koneksi,"
    SELECT *
    FROM jadwal
    WHERE id_kelas='$id_kelas'
    AND hari='$hari'
    AND id_jadwal!='$id'
    AND (
        ('$jam_mulai' BETWEEN jam_mulai AND jam_selesai)
        OR
        ('$jam_selesai' BETWEEN jam_mulai AND jam_selesai)
    )
    ");

    if(mysqli_num_rows($cek)>0){

        echo "<script>
        alert('Jadwal bentrok dengan jadwal lain.');
        window.history.back();
        </script>";
        exit;
    }

    mysqli_query($koneksi,"
    UPDATE jadwal
    SET
        id_guru='$id_guru',
        id_kelas='$id_kelas',
        id_mapel='$id_mapel',
        hari='$hari',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai'
    WHERE id_jadwal='$id'
    ");

    echo "<script>
    alert('Jadwal berhasil diperbarui');
    window.location='jadwal.php';
    </script>";
}

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">
<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold">

<i class="fa fa-calendar text-warning"></i>

Edit Jadwal

</h2>

<p class="text-muted">

Perbarui data jadwal pelajaran.

</p>

</div>

<div class="col-lg-4 text-end">

<a href="jadwal.php"
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

    <!-- Guru -->
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            Guru

        </label>

        <select
            name="id_guru"
            class="form-select"
            required>

            <option value="">-- Pilih Guru --</option>

            <?php while($g = mysqli_fetch_assoc($guru)){ ?>

                <option
                    value="<?= $g['id_guru']; ?>"
                    <?= ($g['id_guru']==$data['id_guru']) ? 'selected' : ''; ?>>

                    <?= htmlspecialchars($g['nama_guru']); ?>

                </option>

            <?php } ?>

        </select>

    </div>

    <!-- Kelas -->
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            Kelas

        </label>

        <select
            name="id_kelas"
            class="form-select"
            required>

            <option value="">-- Pilih Kelas --</option>

            <?php while($k = mysqli_fetch_assoc($kelas)){ ?>

                <option
                    value="<?= $k['id_kelas']; ?>"
                    <?= ($k['id_kelas']==$data['id_kelas']) ? 'selected' : ''; ?>>

                    <?= htmlspecialchars($k['nama_kelas']); ?>

                </option>

            <?php } ?>

        </select>

    </div>

</div>

<div class="row">

    <!-- Mata Pelajaran -->
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            Mata Pelajaran

        </label>

        <select
            name="id_mapel"
            class="form-select"
            required>

            <option value="">-- Pilih Mata Pelajaran --</option>

            <?php while($m = mysqli_fetch_assoc($mapel)){ ?>

                <option
                    value="<?= $m['id_mapel']; ?>"
                    <?= ($m['id_mapel']==$data['id_mapel']) ? 'selected' : ''; ?>>

                    <?= htmlspecialchars($m['nama_mapel']); ?>

                </option>

            <?php } ?>

        </select>

    </div>

    <!-- Hari -->
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            Hari

        </label>

        <select
            name="hari"
            class="form-select"
            required>

            <?php
            $hariList = [
                "Senin",
                "Selasa",
                "Rabu",
                "Kamis",
                "Jumat",
                "Sabtu"
            ];

            foreach($hariList as $h){
            ?>

                <option
                    value="<?= $h ?>"
                    <?= ($h==$data['hari']) ? 'selected' : ''; ?>>

                    <?= $h ?>

                </option>

            <?php } ?>

        </select>

    </div>

</div>

<div class="row">

    <!-- Jam Mulai -->
    <div class="col-md-6 mb-3">

        <label class="form-label fw-semibold">

            Jam Mulai

        </label>

        <input
            type="time"
            name="jam_mulai"
            class="form-control"
            value="<?= $data['jam_mulai']; ?>"
            required>

    </div>

    <!-- Jam Selesai -->
    <div class="col-md-6 mb-4">

        <label class="form-label fw-semibold">

            Jam Selesai

        </label>

        <input
            type="time"
            name="jam_selesai"
            class="form-control"
            value="<?= $data['jam_selesai']; ?>"
            required>

    </div>

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
        href="jadwal.php"
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
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SESSION['role'] != "admin" && $_SESSION['role'] != "guru") {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if (!isset($_GET['id_jadwal'])) {
    die("ID Jadwal tidak ditemukan.");
}

$id_jadwal = (int)$_GET['id_jadwal'];

$query = mysqli_query($koneksi,"
SELECT
    jadwal.*,
    guru.nama_guru,
    mapel.nama_mapel,
    kelas.nama_kelas
FROM jadwal
JOIN guru ON jadwal.id_guru=guru.id_guru
JOIN mapel ON jadwal.id_mapel=mapel.id_mapel
JOIN kelas ON jadwal.id_kelas=kelas.id_kelas
WHERE jadwal.id_jadwal='$id_jadwal'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data jadwal tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Scan QR Code</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://unpkg.com/html5-qrcode"></script>

</head>

<body style="background:#f4f6f9;">

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h4>Scan QR Code</h4>
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p><b>Guru</b><br><?= $data['nama_guru']; ?></p>

<p><b>Mata Pelajaran</b><br><?= $data['nama_mapel']; ?></p>

<p><b>Kelas</b><br><?= $data['nama_kelas']; ?></p>

<p><b>Hari</b><br><?= $data['hari']; ?></p>

<p><b>Jam</b><br><?= $data['jam_mulai']; ?> - <?= $data['jam_selesai']; ?></p>

</div>

<div class="col-md-6">

<div id="reader"></div>

</div>

</div>

<hr>

<div class="alert alert-info">
Status :
<strong id="statusScan">
Menunggu QR Code...
</strong>
</div>

<input
type="text"
id="hasil"
class="form-control"
readonly>

</div>

</div>

</div>

<script>

let sedangProses = false;

function berhasilScan(decodedText){

    if(sedangProses){
        return;
    }

    sedangProses = true;

    document.getElementById("hasil").value = decodedText;
    document.getElementById("statusScan").innerHTML = "Memproses absensi...";

    fetch(
        "simpan.php?id_jadwal=<?= $id_jadwal; ?>&nis=" + encodeURIComponent(decodedText)
    )
    .then(response => response.json())
    .then(data => {

        if(data.status){

            document.getElementById("statusScan").innerHTML =
            "✅ " + data.nama + " berhasil absen.";

        }else{

            document.getElementById("statusScan").innerHTML =
            "❌ " + data.pesan;

        }

        setTimeout(function(){

            document.getElementById("hasil").value = "";
            document.getElementById("statusScan").innerHTML =
            "Menunggu QR Code...";

            sedangProses = false;

        },2000);

    })
    .catch(error=>{

        document.getElementById("statusScan").innerHTML =
        "Terjadi kesalahan.";

        sedangProses = false;

    });

}

let scanner = new Html5QrcodeScanner(
    "reader",
    {
        fps:10,
        qrbox:250
    },
    false
);

scanner.render(berhasilScan);

</script>

</body>
</html>
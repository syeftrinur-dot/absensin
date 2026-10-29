<?php

require '../../vendor/autoload.php';
require_once '../../config/koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$query = mysqli_query($koneksi,"
SELECT
absensi.*,
siswa.nis,
siswa.nama_siswa,
kelas.nama_kelas,
mapel.nama_mapel,
guru.nama_guru

FROM absensi

JOIN siswa ON absensi.id_siswa=siswa.id_siswa
JOIN jadwal ON absensi.id_jadwal=jadwal.id_jadwal
JOIN kelas ON jadwal.id_kelas=kelas.id_kelas
JOIN mapel ON jadwal.id_mapel=mapel.id_mapel
JOIN guru ON jadwal.id_guru=guru.id_guru

WHERE absensi.tanggal='$tanggal'

ORDER BY jam_masuk ASC
");

$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
}

h2,h4{
    text-align:center;
    margin:0;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table, th, td{
    border:1px solid black;
}

th{
    background:#dddddd;
}

th,td{
    padding:6px;
    text-align:center;
}

</style>
</head>
<body>

<h2>LAPORAN ABSENSI SISWA</h2>
<h4>Tanggal : '.$tanggal.'</h4>

<table>

<tr>
<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Mapel</th>
<th>Guru</th>
<th>Jam</th>
<th>Status</th>
</tr>
';

$no=1;

while($d=mysqli_fetch_assoc($query)){

$html .= '
<tr>
<td>'.$no++.'</td>
<td>'.$d['nis'].'</td>
<td>'.$d['nama_siswa'].'</td>
<td>'.$d['nama_kelas'].'</td>
<td>'.$d['nama_mapel'].'</td>
<td>'.$d['nama_guru'].'</td>
<td>'.$d['jam_masuk'].'</td>
<td>'.$d['status'].'</td>
</tr>
';

}

$html .= '
</table>

</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4','landscape');

$dompdf->render();

$dompdf->stream(
    "Laporan_Absensi_".$tanggal.".pdf",
    ["Attachment" => false]
);
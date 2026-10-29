<?php

require '../../vendor/autoload.php';
require_once '../../config/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'LAPORAN ABSENSI');
$sheet->setCellValue('A2', 'Tanggal');
$sheet->setCellValue('B2', $tanggal);

$sheet->setCellValue('A4', 'No');
$sheet->setCellValue('B4', 'NIS');
$sheet->setCellValue('C4', 'Nama');
$sheet->setCellValue('D4', 'Kelas');
$sheet->setCellValue('E4', 'Mapel');
$sheet->setCellValue('F4', 'Guru');
$sheet->setCellValue('G4', 'Jam');
$sheet->setCellValue('H4', 'Status');

$query = mysqli_query($koneksi, "
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

$row = 5;
$no = 1;

while($d = mysqli_fetch_assoc($query)){

    $sheet->setCellValue('A'.$row, $no++);
    $sheet->setCellValue('B'.$row, $d['nis']);
    $sheet->setCellValue('C'.$row, $d['nama_siswa']);
    $sheet->setCellValue('D'.$row, $d['nama_kelas']);
    $sheet->setCellValue('E'.$row, $d['nama_mapel']);
    $sheet->setCellValue('F'.$row, $d['nama_guru']);
    $sheet->setCellValue('G'.$row, $d['jam_masuk']);
    $sheet->setCellValue('H'.$row, $d['status']);

    $row++;
}

foreach(range('A','H') as $column){
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$filename = "Laporan_Absensi_".$tanggal.".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
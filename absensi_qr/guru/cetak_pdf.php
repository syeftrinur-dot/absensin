<?php

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="guru"){

    header("Location: ../login.php");

    exit;

}

include "../koneksi.php";

require("../fpdf/fpdf.php");

$idGuru=$_SESSION['id_guru'];

$tanggal1=isset($_GET['tanggal1']) ? $_GET['tanggal1'] : "";

$tanggal2=isset($_GET['tanggal2']) ? $_GET['tanggal2'] : "";

/* ===========================
   DATA GURU
=========================== */

$qGuru=mysqli_query($koneksi,"
SELECT *
FROM guru
WHERE id_guru='$idGuru'
");

$guru=mysqli_fetch_assoc($qGuru);

/* ===========================
   QUERY LAPORAN
=========================== */

$sql="

SELECT

absensi.*,

siswa.nis,

siswa.nama_siswa,

kelas.nama_kelas,

mapel.nama_mapel

FROM absensi

INNER JOIN siswa

ON siswa.id_siswa=absensi.id_siswa

INNER JOIN jadwal

ON jadwal.id_jadwal=absensi.id_jadwal

INNER JOIN kelas

ON kelas.id_kelas=jadwal.id_kelas

INNER JOIN mapel

ON mapel.id_mapel=jadwal.id_mapel

WHERE jadwal.id_guru='$idGuru'

";

if($tanggal1!="" && $tanggal2!=""){

$sql.="

AND absensi.tanggal

BETWEEN '$tanggal1'

AND '$tanggal2'

";

}

$sql.="

ORDER BY

absensi.tanggal DESC,

absensi.jam_masuk DESC

";

$query=mysqli_query($koneksi,$sql);

/* ===========================
   PDF
=========================== */

$pdf=new FPDF('L','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(0,10,'LAPORAN ABSENSI SISWA',0,1,'C');

$pdf->SetFont('Arial','',11);

$pdf->Cell(0,7,'Sistem Absensi QR Code',0,1,'C');

$pdf->Ln(4);

$pdf->SetFont('Arial','',10);

$pdf->Cell(35,7,'Nama Guru',0,0);

$pdf->Cell(5,7,':',0,0);

$pdf->Cell(80,7,$guru['nama_guru'],0,1);

$pdf->Cell(35,7,'Periode',0,0);

$pdf->Cell(5,7,':',0,0);

if($tanggal1!="" && $tanggal2!=""){

$pdf->Cell(

80,

7,

date('d-m-Y',strtotime($tanggal1))

." s/d ".

date('d-m-Y',strtotime($tanggal2)),

0,

1

);

}else{

$pdf->Cell(80,7,"Semua Data",0,1);

}

$pdf->Ln(5);

/* ===========================
   HEADER TABEL
=========================== */

$pdf->SetFillColor(41,128,185);

$pdf->SetTextColor(255);

$pdf->SetFont('Arial','B',9);

$pdf->Cell(10,8,'No',1,0,'C',true);

$pdf->Cell(25,8,'Tanggal',1,0,'C',true);

$pdf->Cell(25,8,'NIS',1,0,'C',true);

$pdf->Cell(55,8,'Nama',1,0,'C',true);

$pdf->Cell(30,8,'Kelas',1,0,'C',true);

$pdf->Cell(50,8,'Mapel',1,0,'C',true);

$pdf->Cell(25,8,'Jam',1,0,'C',true);

$pdf->Cell(25,8,'Status',1,1,'C',true);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(0);

$no=1;

while($d=mysqli_fetch_assoc($query)){

$pdf->Cell(10,8,$no++,1);

$pdf->Cell(25,8,date('d-m-Y',strtotime($d['tanggal'])),1);

$pdf->Cell(25,8,$d['nis'],1);

$pdf->Cell(55,8,utf8_decode($d['nama_siswa']),1);

$pdf->Cell(30,8,$d['nama_kelas'],1);

$pdf->Cell(50,8,utf8_decode($d['nama_mapel']),1);

$pdf->Cell(25,8,substr($d['jam_masuk'],0,5),1);

$pdf->Cell(25,8,$d['status'],1);

$pdf->Ln();

}

$pdf->Ln(10);

$pdf->Cell(0,7,"Dicetak pada : ".date("d-m-Y H:i"),0,1,'R');

$pdf->Output("I","Laporan_Absensi.pdf");
<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if(isset($_POST['simpan'])){

    $nis   = mysqli_real_escape_string($koneksi,$_POST['nis']);
    $nama  = mysqli_real_escape_string($koneksi,$_POST['nama_siswa']);
    $jk    = mysqli_real_escape_string($koneksi,$_POST['jk']);
    $kelas = mysqli_real_escape_string($koneksi,$_POST['kelas']);
    $alamat= mysqli_real_escape_string($koneksi,$_POST['alamat']);

    // Cek NIS
    $cek = mysqli_query($koneksi,"SELECT * FROM siswa WHERE nis='$nis'");

    if(mysqli_num_rows($cek)>0){
        echo "<script>
                alert('NIS sudah digunakan!');
                window.history.back();
              </script>";
        exit;
    }

    $simpan = mysqli_query($koneksi,"INSERT INTO siswa
        (nis,nama_siswa,jk,kelas,alamat)
        VALUES
        ('$nis','$nama','$jk','$kelas','$alamat')
    ");

    if($simpan){
        echo "<script>
                alert('Data siswa berhasil ditambahkan');
                window.location='index.php';
              </script>";
    }else{
        echo "<script>
                alert('Gagal menyimpan data');
              </script>";
    }

}

include "../../layout/header.php";
include "../../layout/sidebar.php";
?>

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Data Siswa</h4>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>

                    <select name="jk" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">L</option>
                        <option value="Perempuan">P</option>
                    </select>

                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="4" class="form-control"></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

<?php include "../../layout/footer.php"; ?>
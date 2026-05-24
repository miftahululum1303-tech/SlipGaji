<?php
// Pastikan jalur ini mengarah ke file koneksi Anda
include '../config/koneksi.php'; 

if(isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$nik'");
    $data = mysqli_fetch_assoc($query);
    
    // Kirim data ke browser dalam format JSON
    echo json_encode($data);
    exit;
}
?>
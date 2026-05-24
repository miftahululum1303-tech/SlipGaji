<?php
include '../config/koneksi.php';

if(isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    // Mencari data karyawan berdasarkan NIK
    $query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$nik'");
    $data = mysqli_fetch_assoc($query);
    
    echo json_encode($data);
    exit;
}
?>
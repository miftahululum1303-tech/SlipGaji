<?php
$id_user_header = $_SESSION['id_user'];

$query_header = mysqli_query(
    $koneksi,

    "SELECT users.*, karyawan.*
     FROM users
     LEFT JOIN karyawan
     ON users.id_karyawan = karyawan.id_karyawan
     WHERE users.id_user='$id_user_header'",
);

$data_header = mysqli_fetch_assoc($query_header);
$nama_header = $data_header['nama_karyawan'] ?? $data_header['username'];
$role_header = ucfirst($data_header['role']);
$foto_header = 'https://ui-avatars.com/api/?name=' . urlencode($nama_header) . '&background=38bdf8&color=1e293b&size=40';

if (!empty($data_header['foto']) && file_exists('assets/uploads/' . $data_header['foto'])) {
    $foto_header = 'assets/uploads/' . $data_header['foto'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Payroll System -
        <?= ucfirst($_GET['page'] ?? 'dashboard') ?>
    </title>
    <!-- CDN Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/datatable.css">
</head>
<body>

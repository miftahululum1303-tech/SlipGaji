<?php
session_start();

include '../config/koneksi.php';

$username = $_POST['username'];
$password = MD5($_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");

$data = mysqli_fetch_assoc($query);

if ($data) {
    if ($password == $data['password']) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['id_karyawan'] = $data['id_karyawan'];

        if ($data['role'] == 'admin') {
            header('Location: ../index.php');
        } else {
            header('Location: ../index.php');
        }
    } else {
        echo 'Password salah';
    }
} else {
    echo 'Username tidak ditemukan';
}

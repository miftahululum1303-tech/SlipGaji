<?php

session_start();

include '../config/koneksi.php';

/* ========================================
   VALIDASI METHOD
======================================== */

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: login.php');

    exit();
}

/* ========================================
   AMBIL INPUT
======================================== */

$username = trim($_POST['username'] ?? '');

$password = trim($_POST['password'] ?? '');

/* ========================================
   VALIDASI INPUT
======================================== */

if (empty($username) || empty($password)) {
    header('Location: login.php?error=empty');

    exit();
}

/* ========================================
   SANITASI
======================================== */

$username = mysqli_real_escape_string($koneksi, $username);

$password = md5($password);

/* ========================================
   QUERY LOGIN
======================================== */

$query = mysqli_query(
    $koneksi,
    "SELECT *
     FROM users
     WHERE username='$username'
     LIMIT 1",
);

/* ========================================
   USER DITEMUKAN
======================================== */

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    /* PASSWORD BENAR */
    if ($password == $data['password']) {
        $_SESSION['login'] = true;

        $_SESSION['id_user'] = $data['id_user'];

        $_SESSION['role'] = $data['role'];

        $_SESSION['id_karyawan'] = $data['id_karyawan'];

        $_SESSION['username'] = $data['username'];

        /* ========================================
           REDIRECT ROLE
        ======================================== */

        if ($data['role'] == 'admin') {
            header('Location: ../index.php');
        } else {
            header('Location: ../index.php');
        }

        exit();
    }
    /* PASSWORD SALAH */ else {
        header('Location: login.php?error=password');

        exit();
    }
}
/* ========================================
   USER TIDAK DITEMUKAN
======================================== */ else {
    header('Location: login.php?error=username');

    exit();
}

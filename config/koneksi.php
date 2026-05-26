<?php

/* ========================================
   KONFIGURASI DATABASE
======================================== */

$host = 'localhost';

$username = 'root';

$password = '';

$database = 'proyek';

/* ========================================
   KONEKSI MYSQLI
======================================== */

$koneksi = mysqli_connect($host, $username, $password, $database);

/* ========================================
   CEK KONEKSI
======================================== */

if (!$koneksi) {
    die('Koneksi database gagal : ' . mysqli_connect_error());
}

/* ========================================
   DEFAULT CHARSET
======================================== */

mysqli_set_charset($koneksi, 'utf8mb4');

/* ========================================
   DEFAULT TIMEZONE
======================================== */

date_default_timezone_set('Asia/Jakarta');

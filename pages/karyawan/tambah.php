<?php

/* ========================================
   TAMBAH KARYAWAN
======================================== */

if (isset($_POST['simpan_karyawan'])) {
    /* ========================================
       AMBIL DATA
    ======================================== */

    $nama = trim($_POST['nama'] ?? '');

    /* ========================================
       VALIDASI
    ======================================== */

    if (empty($nama)) {
        echo "

        <script>
            alert('Nama karyawan wajib diisi');

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }

    /* ========================================
       GENERATE ID TERAKHIR
    ======================================== */

    $queryLast = mysqli_query(
        $koneksi,

        "SELECT id_karyawan
         FROM karyawan
         ORDER BY id_karyawan DESC
         LIMIT 1",
    );

    $dataLast = mysqli_fetch_assoc($queryLast);

    $lastId = $dataLast ? $dataLast['id_karyawan'] + 1 : 1;

    /* ========================================
       GENERATE NIK
    ======================================== */

    $nik = 'KRY' . str_pad($lastId, 3, '0', STR_PAD_LEFT);

    /* ========================================
       SANITASI
    ======================================== */

    $nama = mysqli_real_escape_string(
        $koneksi,

        $nama,
    );

    /* ========================================
       INSERT KARYAWAN
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO karyawan (

            nik,
            nama_karyawan

        ) VALUES (

            '$nik',
            '$nama'

        )",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($insert) {
        $idKaryawan = mysqli_insert_id($koneksi);

        /* ========================================
           AUTO AKUN LOGIN
        ======================================== */

        $username = $nik;

        $password = md5('123456');

        mysqli_query(
            $koneksi,

            "INSERT INTO users (

                id_karyawan,
                username,
                password,
                role

            ) VALUES (

                '$idKaryawan',
                '$username',
                '$password',
                'karyawan'

            )",
        );

        echo "

        <script>
            alert(
                'Data karyawan berhasil ditambahkan'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }
    /* ========================================
       GAGAL
    ======================================== */ else {
        echo "

        <script>
            alert(
                'Gagal menambahkan data karyawan'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }
}

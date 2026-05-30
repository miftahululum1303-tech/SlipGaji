<?php

/* ========================================
   TAMBAH DATA JABATAN
======================================== */

if (isset($_POST['simpan_jabatan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $namaJabatan = trim($_POST['nama_jabatan'] ?? '');

    $tunjanganJabatan = intval($_POST['tunjangan_jabatan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if (empty($namaJabatan) || $tunjanganJabatan < 0) {
        echo "

        <script>
            alert(
                'Data jabatan tidak valid'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $namaJabatan = mysqli_real_escape_string(
        $koneksi,

        $namaJabatan,
    );

    /* ========================================
       CEK DUPLIKAT
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM jabatan
         WHERE nama_jabatan='$namaJabatan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Nama jabatan sudah tersedia'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       INSERT DATA
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO jabatan (

            nama_jabatan,
            tunjangan_jabatan

        ) VALUES (

            '$namaJabatan',
            '$tunjanganJabatan'

        )",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($insert) {
        echo "

        <script>
            alert(
                'Data jabatan berhasil ditambahkan'
            );

            window.location =
                'index.php?page=jabatan';
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
                'Gagal menambahkan data jabatan'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }
}
    
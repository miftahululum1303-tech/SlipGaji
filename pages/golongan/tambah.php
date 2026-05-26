<?php

/* ========================================
   TAMBAH DATA GOLONGAN
======================================== */

if (isset($_POST['simpan_golongan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $namaGolongan = trim($_POST['nama_golongan'] ?? '');

    $tunjanganGolongan = intval($_POST['tunjangan_golongan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if (empty($namaGolongan) || $tunjanganGolongan <= 0) {
        echo "

        <script>
            alert(
                'Data golongan tidak valid'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $namaGolongan = mysqli_real_escape_string(
        $koneksi,

        $namaGolongan,
    );

    /* ========================================
       CEK DUPLIKAT
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM golongan
         WHERE nama_golongan='$namaGolongan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Nama golongan sudah tersedia'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       INSERT DATA
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO golongan (

            nama_golongan,
            tunjangan_golongan

        ) VALUES (

            '$namaGolongan',
            '$tunjanganGolongan'

        )",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($insert) {
        echo "

        <script>
            alert(
                'Data golongan berhasil ditambahkan'
            );

            window.location =
                'index.php?page=golongan';
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
                'Gagal menambahkan data golongan'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }
}

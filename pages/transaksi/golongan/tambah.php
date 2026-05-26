<?php

/* ========================================
   TAMBAH TRANSAKSI GOLONGAN
======================================== */

if (isset($_POST['simpan_transaksi_golongan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $idGolongan = intval($_POST['id_golongan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idKaryawan <= 0 || $idGolongan <= 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak valid'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       CEK DUPLIKAT
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM transaksi_golongan
         WHERE id_karyawan='$idKaryawan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Karyawan sudah memiliki golongan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       INSERT TRANSAKSI
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO transaksi_golongan (

            id_karyawan,
            id_golongan,
            tanggal_mulai

        ) VALUES (

            '$idKaryawan',
            '$idGolongan',
            NOW()

        )",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($insert) {
        echo "

        <script>
            alert(
                'Transaksi golongan berhasil ditambahkan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
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
                'Gagal menambahkan transaksi golongan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }
}

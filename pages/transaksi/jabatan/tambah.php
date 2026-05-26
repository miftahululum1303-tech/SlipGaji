<?php

/* ========================================
   TAMBAH TRANSAKSI JABATAN
======================================== */

if (isset($_POST['simpan_transaksi_jabatan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $idJabatan = intval($_POST['id_jabatan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idKaryawan <= 0 || $idJabatan <= 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak valid'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
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
         FROM transaksi_jabatan
         WHERE id_karyawan='$idKaryawan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Karyawan sudah memiliki jabatan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       INSERT TRANSAKSI
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO transaksi_jabatan (

            id_karyawan,
            id_jabatan,
            tanggal_mulai

        ) VALUES (

            '$idKaryawan',
            '$idJabatan',
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
                'Transaksi jabatan berhasil ditambahkan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
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
                'Gagal menambahkan transaksi jabatan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }
}

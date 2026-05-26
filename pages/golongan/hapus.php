<?php

/* ========================================
   HAPUS DATA GOLONGAN
======================================== */

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    /* ========================================
       AMBIL ID
    ======================================== */

    $idGolongan = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idGolongan <= 0) {
        echo "

        <script>
            alert(
                'ID golongan tidak valid'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       CEK RELASI TRANSAKSI
    ======================================== */

    $cekRelasi = mysqli_query(
        $koneksi,

        "SELECT *
         FROM transaksi_golongan
         WHERE id_golongan='$idGolongan'
         LIMIT 1",
    );

    if (mysqli_num_rows($cekRelasi) > 0) {
        echo "

        <script>
            alert(
                'Data golongan tidak dapat dihapus karena masih digunakan pada transaksi'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS DATA
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM golongan
         WHERE id_golongan='$idGolongan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Data golongan berhasil dihapus'
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
                'Gagal menghapus data golongan'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }
}

<?php

/* ========================================
   HAPUS DATA JABATAN
======================================== */

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    /* ========================================
       AMBIL ID
    ======================================== */

    $idJabatan = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idJabatan <= 0) {
        echo "

        <script>
            alert(
                'ID jabatan tidak valid'
            );

            window.location =
                'index.php?page=jabatan';
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
         FROM transaksi_jabatan
         WHERE id_jabatan='$idJabatan'
         LIMIT 1",
    );

    if (mysqli_num_rows($cekRelasi) > 0) {
        echo "

        <script>
            alert(
                'Data jabatan tidak dapat dihapus karena masih digunakan pada transaksi'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS DATA
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM jabatan
         WHERE id_jabatan='$idJabatan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Data jabatan berhasil dihapus'
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
                'Gagal menghapus data jabatan'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }
}

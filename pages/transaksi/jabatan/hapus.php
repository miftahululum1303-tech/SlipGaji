<?php

/* ========================================
   HAPUS TRANSAKSI JABATAN
======================================== */

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    /* ========================================
       AMBIL ID
    ======================================== */

    $idTransaksi = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idTransaksi <= 0) {
        echo "

        <script>
            alert(
                'ID transaksi tidak valid'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       CEK DATA
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM transaksi_jabatan
         WHERE id_transaksi_jabatan='$idTransaksi'",
    );

    if (mysqli_num_rows($cek) == 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak ditemukan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS DATA
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM transaksi_jabatan
         WHERE id_transaksi_jabatan='$idTransaksi'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Transaksi jabatan berhasil dihapus'
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
                'Gagal menghapus transaksi jabatan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }
}

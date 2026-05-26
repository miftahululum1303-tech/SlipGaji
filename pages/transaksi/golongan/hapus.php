<?php

/* ========================================
   HAPUS TRANSAKSI GOLONGAN
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
                'index.php?page=transaksi_golongan';
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
         FROM transaksi_golongan
         WHERE id_transaksi_golongan='$idTransaksi'",
    );

    if (mysqli_num_rows($cek) == 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak ditemukan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS DATA
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM transaksi_golongan
         WHERE id_transaksi_golongan='$idTransaksi'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Transaksi golongan berhasil dihapus'
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
                'Gagal menghapus transaksi golongan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }
}

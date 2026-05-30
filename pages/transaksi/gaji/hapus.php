<?php

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI ID
    ======================================== */

    if ($id <= 0) {
        echo "

        <script>
            alert(
                'ID payroll tidak valid'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS TRANSAKSI GAJI
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM transaksi_gaji
         WHERE id_gaji='$id'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Payroll berhasil dihapus'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";
    }
    /* ========================================
       GAGAL
    ======================================== */ else {
        echo "

        <script>
            alert(
                'Gagal menghapus payroll'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";
    }
}

<?php

/* ========================================
   HAPUS DATA KARYAWAN
======================================== */

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    /* ========================================
       AMBIL ID
    ======================================== */

    $idHapus = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idHapus <= 0) {
        echo "

        <script>
            alert(
                'ID karyawan tidak valid'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }

    /* ========================================
       HAPUS USER TERKAIT
    ======================================== */

    mysqli_query(
        $koneksi,

        "DELETE FROM users

         WHERE id_karyawan='$idHapus'",
    );

    /* ========================================
       HAPUS KARYAWAN
    ======================================== */

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM karyawan

         WHERE id_karyawan='$idHapus'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($hapus) {
        echo "

        <script>
            alert(
                'Data karyawan berhasil dihapus'
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
                'Gagal menghapus data karyawan'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }
}

/* ========================================
   RESET PASSWORD
======================================== */

if (isset($_GET['action']) && $_GET['action'] == 'reset') {
    /* ========================================
       AMBIL ID
    ======================================== */

    $idReset = intval($_GET['id'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idReset <= 0) {
        echo "

        <script>
            alert(
                'ID karyawan tidak valid'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }

    /* ========================================
       PASSWORD DEFAULT
    ======================================== */

    $passwordBaru = md5('123456');

    /* ========================================
       UPDATE PASSWORD
    ======================================== */

    $reset = mysqli_query(
        $koneksi,

        "UPDATE users

         SET password='$passwordBaru'

         WHERE id_karyawan='$idReset'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($reset) {
        echo "

        <script>
            alert(
                'Password berhasil direset menjadi 123456'
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
                'Gagal reset password'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }
}

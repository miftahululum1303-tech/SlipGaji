<?php

/* ========================================
   UPDATE DATA KARYAWAN
======================================== */

if (isset($_POST['update_karyawan'])) {
    /* ========================================
       AMBIL DATA
    ======================================== */

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $nama = trim($_POST['nama'] ?? '');

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idKaryawan <= 0 || empty($nama)) {
        echo "

        <script>
            alert(
                'Data tidak valid'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $nama = mysqli_real_escape_string(
        $koneksi,

        $nama,
    );

    /* ========================================
       UPDATE DATA
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE karyawan

         SET

            nama_karyawan = '$nama'

         WHERE

            id_karyawan = '$idKaryawan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Data karyawan berhasil diperbarui'
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
                'Gagal memperbarui data karyawan'
            );

            window.location =
                'index.php?page=karyawan';
        </script>

        ";

        exit();
    }
}

<?php

/* ========================================
   UPDATE DATA JABATAN
======================================== */

if (isset($_POST['update_jabatan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idJabatan = intval($_POST['id_jabatan'] ?? 0);

    $namaJabatan = trim($_POST['nama_jabatan'] ?? '');

    $gajiPokok = intval($_POST['gaji_pokok'] ?? 0);

    $tunjanganJabatan = intval($_POST['tunjangan_jabatan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idJabatan <= 0 || empty($namaJabatan) || $gajiPokok <= 0 || $tunjanganJabatan < 0) {
        echo "

        <script>
            alert(
                'Data jabatan tidak valid'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $namaJabatan = mysqli_real_escape_string(
        $koneksi,

        $namaJabatan,
    );

    /* ========================================
       CEK DUPLIKAT
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM jabatan
         WHERE nama_jabatan='$namaJabatan'
         AND id_jabatan != '$idJabatan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Nama jabatan sudah digunakan'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       UPDATE DATA
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE jabatan

         SET

            nama_jabatan = '$namaJabatan',
            gaji_pokok = '$gajiPokok',
            tunjangan_jabatan = '$tunjanganJabatan'

         WHERE

            id_jabatan = '$idJabatan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Data jabatan berhasil diperbarui'
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
                'Gagal memperbarui data jabatan'
            );

            window.location =
                'index.php?page=jabatan';
        </script>

        ";

        exit();
    }
}

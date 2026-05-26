<?php

/* ========================================
   UPDATE DATA GOLONGAN
======================================== */

if (isset($_POST['update_golongan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idGolongan = intval($_POST['id_golongan'] ?? 0);

    $namaGolongan = trim($_POST['nama_golongan'] ?? '');

    $tunjanganGolongan = intval($_POST['tunjangan_golongan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idGolongan <= 0 || empty($namaGolongan) || $tunjanganGolongan <= 0) {
        echo "

        <script>
            alert(
                'Data golongan tidak valid'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $namaGolongan = mysqli_real_escape_string(
        $koneksi,

        $namaGolongan,
    );

    /* ========================================
       CEK DUPLIKAT
    ======================================== */

    $cek = mysqli_query(
        $koneksi,

        "SELECT *
         FROM golongan
         WHERE nama_golongan='$namaGolongan'
         AND id_golongan != '$idGolongan'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Nama golongan sudah digunakan'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       UPDATE DATA
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE golongan

         SET

            nama_golongan = '$namaGolongan',
            tunjangan_golongan = '$tunjanganGolongan'

         WHERE

            id_golongan = '$idGolongan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Data golongan berhasil diperbarui'
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
                'Gagal memperbarui data golongan'
            );

            window.location =
                'index.php?page=golongan';
        </script>

        ";

        exit();
    }
}

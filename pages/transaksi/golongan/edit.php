<?php

/* ========================================
   UPDATE TRANSAKSI GOLONGAN
======================================== */

if (isset($_POST['update_transaksi_golongan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idTransaksi = intval($_POST['id_transaksi_golongan'] ?? 0);

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $idGolongan = intval($_POST['id_golongan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idTransaksi <= 0 || $idKaryawan <= 0 || $idGolongan <= 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak valid'
            );

            window.location =
                'index.php?page=transaksi_golongan';
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
         FROM transaksi_golongan
         WHERE id_karyawan='$idKaryawan'
         AND id_transaksi_golongan != '$idTransaksi'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Karyawan sudah memiliki golongan lain'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }

    /* ========================================
       UPDATE DATA
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE transaksi_golongan

         SET

            id_karyawan = '$idKaryawan',
            id_golongan = '$idGolongan'

         WHERE

            id_transaksi_golongan = '$idTransaksi'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Transaksi golongan berhasil diperbarui'
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
                'Gagal memperbarui transaksi golongan'
            );

            window.location =
                'index.php?page=transaksi_golongan';
        </script>

        ";

        exit();
    }
}

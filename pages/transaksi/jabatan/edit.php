<?php

/* ========================================
   UPDATE TRANSAKSI JABATAN
======================================== */

if (isset($_POST['update_transaksi_jabatan'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idTransaksi = intval($_POST['id_transaksi_jabatan'] ?? 0);

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $idJabatan = intval($_POST['id_jabatan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idTransaksi <= 0 || $idKaryawan <= 0 || $idJabatan <= 0) {
        echo "

        <script>
            alert(
                'Data transaksi tidak valid'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
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
         FROM transaksi_jabatan
         WHERE id_karyawan='$idKaryawan'
         AND id_transaksi_jabatan != '$idTransaksi'",
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "

        <script>
            alert(
                'Karyawan sudah memiliki jabatan lain'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }

    /* ========================================
       UPDATE DATA
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE transaksi_jabatan

         SET

            id_karyawan = '$idKaryawan',
            id_jabatan = '$idJabatan'

         WHERE

            id_transaksi_jabatan = '$idTransaksi'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Transaksi jabatan berhasil diperbarui'
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
                'Gagal memperbarui transaksi jabatan'
            );

            window.location =
                'index.php?page=transaksi_jabatan';
        </script>

        ";

        exit();
    }
}

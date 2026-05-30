<?php

if (isset($_POST['update_payroll'])) {
    $idGaji = intval($_POST['id_gaji']);

    $bonus = intval($_POST['bonus']);

    $potongan = intval($_POST['potongan']);

    /* ========================================
       AMBIL DATA
    ======================================== */

    $query = mysqli_query(
        $koneksi,

        "SELECT *

         FROM transaksi_gaji

         WHERE id_gaji='$idGaji'

         LIMIT 1",
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $totalGaji = $data['gaji_pokok'] + $data['tunjangan_jabatan'] + $bonus - $potongan;

        mysqli_query(
            $koneksi,

            "UPDATE transaksi_gaji

             SET

                bonus='$bonus',
                potongan='$potongan',

                total_gaji='$totalGaji'

             WHERE

                id_gaji='$idGaji'",
        );
    }

    echo "

    <script>
        alert(
            'Payroll berhasil diperbarui'
        );

        window.location =
            'index.php?page=transaksi_gaji';
    </script>

    ";
}

<?php

if (isset($_POST['generate_semua_gaji'])) {
    $periode = trim($_POST['periode'] ?? '');

    /* VALIDASI */
    if (empty($periode)) {
        echo "

        <script>
            alert('Periode wajib dipilih');

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }

    /* AMBIL KARYAWAN */
    $karyawan = mysqli_query(
        $koneksi,

        "SELECT *
         FROM karyawan",
    );

    while ($k = mysqli_fetch_assoc($karyawan)) {
        $idKaryawan = $k['id_karyawan'];

        /* CEK DUPLIKAT */
        $cek = mysqli_query(
            $koneksi,

            "SELECT *
             FROM transaksi_gaji

             WHERE

                id_karyawan='$idKaryawan'

             AND

                periode='$periode'",
        );

        if (mysqli_num_rows($cek) > 0) {
            continue;
        }

        /* GOLONGAN */
        $golongan = mysqli_query(
            $koneksi,

            "SELECT

                g.gaji_pokok

             FROM transaksi_golongan tg

             INNER JOIN golongan g
                ON tg.id_golongan =
                   g.id_golongan

             WHERE
                tg.id_karyawan='$idKaryawan'

             LIMIT 1",
        );

        $g = mysqli_fetch_assoc($golongan);

        $gajiPokok = $g['gaji_pokok'] ?? 0;

        /* JABATAN */
        $jabatan = mysqli_query(
            $koneksi,

            "SELECT

                j.tunjangan_jabatan

             FROM transaksi_jabatan tj

             INNER JOIN jabatan j
                ON tj.id_jabatan =
                   j.id_jabatan

             WHERE
                tj.id_karyawan='$idKaryawan'

             LIMIT 1",
        );

        $j = mysqli_fetch_assoc($jabatan);

        $tunjanganJabatan = $j['tunjangan_jabatan'] ?? 0;

        /* TOTAL */
        $totalGaji = $gajiPokok + $tunjanganJabatan;

        /* INSERT */
        mysqli_query(
            $koneksi,

            "INSERT INTO transaksi_gaji (

                id_karyawan,
                periode,

                gaji_pokok,
                tunjangan_jabatan,

                bonus,
                potongan,

                total_gaji,
                tanggal_gaji

            ) VALUES (

                '$idKaryawan',
                '$periode',

                '$gajiPokok',
                '$tunjanganJabatan',

                '0',
                '0',

                '$totalGaji',
                NOW()

            )",
        );
    }

    echo "

    <script>
        alert(
            'Payroll berhasil digenerate'
        );

        window.location =
            'index.php?page=transaksi_gaji';
    </script>

    ";
}

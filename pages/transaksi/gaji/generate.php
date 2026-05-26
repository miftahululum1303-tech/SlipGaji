<?php

/* ========================================
   GENERATE TRANSAKSI GAJI
======================================== */

if (isset($_POST['generate_gaji'])) {
    /* ========================================
       AMBIL INPUT
    ======================================== */

    $idKaryawan = intval($_POST['id_karyawan'] ?? 0);

    $periode = trim($_POST['periode'] ?? '');

    $bonus = intval($_POST['bonus'] ?? 0);

    $potongan = intval($_POST['potongan'] ?? 0);

    /* ========================================
       VALIDASI
    ======================================== */

    if ($idKaryawan <= 0 || empty($periode)) {
        echo "

        <script>
            alert(
                'Data payroll tidak valid'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }

    /* ========================================
       CEK DUPLIKAT PERIODE
    ======================================== */

    $cekPayroll = mysqli_query(
        $koneksi,

        "SELECT *
         FROM transaksi_gaji
         WHERE

            id_karyawan='$idKaryawan'

         AND

            periode='$periode'",
    );

    if (mysqli_num_rows($cekPayroll) > 0) {
        echo "

        <script>
            alert(
                'Payroll untuk periode tersebut sudah tersedia'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }

    /* ========================================
       AMBIL DATA JABATAN
    ======================================== */

    $jabatan = mysqli_query(
        $koneksi,

        "SELECT

            j.nama_jabatan,
            j.gaji_pokok,
            j.tunjangan_jabatan

         FROM transaksi_jabatan tj

         INNER JOIN jabatan j
            ON tj.id_jabatan =
               j.id_jabatan

         WHERE
            tj.id_karyawan='$idKaryawan'

         LIMIT 1",
    );

    /* ========================================
       AMBIL DATA GOLONGAN
    ======================================== */

    $golongan = mysqli_query(
        $koneksi,

        "SELECT

            g.nama_golongan,
            g.tunjangan_golongan

         FROM transaksi_golongan tg

         INNER JOIN golongan g
            ON tg.id_golongan =
               g.id_golongan

         WHERE
            tg.id_karyawan='$idKaryawan'

         LIMIT 1",
    );

    $dataJabatan = mysqli_fetch_assoc($jabatan);

    $dataGolongan = mysqli_fetch_assoc($golongan);

    /* ========================================
       VALIDASI RELASI
    ======================================== */

    if (!$dataJabatan || !$dataGolongan) {
        echo "

        <script>
            alert(
                'Karyawan belum memiliki jabatan atau golongan'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }

    /* ========================================
       HITUNG TOTAL
    ======================================== */

    $gajiPokok = intval($dataJabatan['gaji_pokok']);

    $tunjanganJabatan = intval($dataJabatan['tunjangan_jabatan']);

    $tunjanganGolongan = intval($dataGolongan['tunjangan_golongan']);

    $totalGaji = $gajiPokok + $tunjanganJabatan + $tunjanganGolongan + $bonus - $potongan;

    /* ========================================
       INSERT PAYROLL
    ======================================== */

    $insert = mysqli_query(
        $koneksi,

        "INSERT INTO transaksi_gaji (

            id_karyawan,
            periode,

            gaji_pokok,
            tunjangan_jabatan,
            tunjangan_golongan,

            bonus,
            potongan,

            total_gaji,
            tanggal_gaji

        ) VALUES (

            '$idKaryawan',
            '$periode',

            '$gajiPokok',
            '$tunjanganJabatan',
            '$tunjanganGolongan',

            '$bonus',
            '$potongan',

            '$totalGaji',
            NOW()

        )",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($insert) {
        echo "

        <script>
            alert(
                'Payroll berhasil digenerate'
            );

            window.location =
                'index.php?page=transaksi_gaji';
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
                'Gagal generate payroll'
            );

            window.location =
                'index.php?page=transaksi_gaji';
        </script>

        ";

        exit();
    }
}

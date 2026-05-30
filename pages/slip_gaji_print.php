<?php

session_start();

include '../config/koneksi.php';

/* ========================================
   VALIDASI ID
======================================== */

$idGaji = intval($_GET['id'] ?? 0);

if ($idGaji <= 0) {
    die('ID payroll tidak valid');
}

/* ========================================
   QUERY
======================================== */

$query = mysqli_query(
    $koneksi,

    "SELECT

        tg.*,

        k.nik,
        k.nama_karyawan,

        j.nama_jabatan,

        g.nama_golongan

     FROM transaksi_gaji tg

     INNER JOIN karyawan k
        ON tg.id_karyawan =
           k.id_karyawan

     INNER JOIN transaksi_jabatan tj
        ON k.id_karyawan =
           tj.id_karyawan

     INNER JOIN jabatan j
        ON tj.id_jabatan =
           j.id_jabatan

     INNER JOIN transaksi_golongan trg
        ON k.id_karyawan =
           trg.id_karyawan

     INNER JOIN golongan g
        ON trg.id_golongan =
           g.id_golongan

     WHERE
        tg.id_gaji='$idGaji'

     LIMIT 1",
);

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die('Data payroll tidak ditemukan');
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>

        Slip Gaji -
        <?= $data['nama_karyawan'] ?>

    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            padding: 40px;
            font-family: sans-serif;
        }

        .slip-container {
            max-width: 850px;
            margin: auto;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow:
                0 5px 20px rgba(0, 0, 0, .08);
        }

        .table td,
        .table th {
            padding: 16px;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .slip-container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

        }
    </style>

</head>

<body>


    <div class="slip-container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom">

            <!-- COMPANY -->
            <div>

                <h2 class="fw-bold mb-1 text-primary">

                    PAYROLL SYSTEM

                </h2>

                <p class="text-muted mb-1">

                    PT. Ranma Digital Indonesia

                </p>

                <small class="text-muted">

                    Sistem Informasi Payroll Karyawan

                </small>

            </div>


            <!-- SLIP -->
            <div class="text-end">

                <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">

                    <?= $data['periode'] ?>

                </span>

                <h5 class="fw-bold mb-1">

                    SLIP GAJI

                </h5>

                <small class="text-muted">

                    No:
                    SLIP-<?= str_pad($data['id_gaji'], 5, '0', STR_PAD_LEFT) ?>

                </small>

            </div>

        </div>

        <!-- IDENTITAS -->
        <div class="row g-3 mb-5">

            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        NIK

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nik'] ?>

                    </h6>

                </div>

            </div>


            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        Nama Karyawan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_karyawan'] ?>

                    </h6>

                </div>

            </div>


            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        Jabatan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_jabatan'] ?>

                    </h6>

                </div>

            </div>


            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        Golongan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_golongan'] ?>

                    </h6>

                </div>

            </div>

        </div>

        <!-- TABLE -->
        <table class="table table-bordered align-middle">

            <tbody>

                <!-- GAJI -->
                <tr>

                    <th width="70%">

                        Gaji Pokok

                    </th>

                    <td class="fw-bold text-primary">

                        Rp
                        <?= number_format($data['gaji_pokok'], 0, ',', '.') ?>

                    </td>

                </tr>


                <!-- TUNJANGAN -->
                <tr>

                    <th>

                        Tunjangan Jabatan

                    </th>

                    <td class="fw-bold text-info">

                        Rp
                        <?= number_format($data['tunjangan_jabatan'], 0, ',', '.') ?>

                    </td>

                </tr>


                <!-- BONUS -->
                <tr>

                    <th>

                        Bonus

                    </th>

                    <td class="fw-bold text-success">

                        Rp
                        <?= number_format($data['bonus'], 0, ',', '.') ?>

                    </td>

                </tr>


                <!-- POTONGAN -->
                <tr>

                    <th>

                        Potongan

                    </th>

                    <td class="fw-bold text-danger">

                        Rp
                        <?= number_format($data['potongan'], 0, ',', '.') ?>

                    </td>

                </tr>


                <!-- TOTAL -->
                <tr class="table-success">

                    <th class="fs-5">

                        Total Gaji

                    </th>

                    <td class="fw-bold fs-4">

                        Rp
                        <?= number_format($data['total_gaji'], 0, ',', '.') ?>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- FOOTER -->
        <div class="row mt-5 pt-4 border-top">

            <!-- LEFT -->
            <div class="col-6">

                <small class="text-muted d-block mb-2">

                    Dicetak pada:

                </small>

                <strong>

                    <?= date('d F Y H:i') ?>

                </strong>

            </div>

            <!-- RIGHT -->
            <div class="col-6 text-end">

                <p class="mb-5">

                    Mengetahui,

                </p>

                <h6 class="fw-bold text-decoration-underline mb-1">

                    HR Payroll

                </h6>

                <small class="text-muted">

                    PT. Ranma Digital Indonesia

                </small>

            </div>

        </div>


        <!-- BUTTON -->
        <div class="text-center mt-5 no-print">

            <button onclick="window.print()" class="btn btn-primary px-4">

                Print Slip

            </button>

        </div>

    </div>
    <script>
        window.onload = function() {

            window.print();

        }
    </script>
</body>

</html>

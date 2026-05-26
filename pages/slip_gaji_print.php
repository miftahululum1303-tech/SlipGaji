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
            background: white;
            padding: 40px;
            font-family: sans-serif;
        }

        .slip-container {
            max-width: 850px;
            margin: auto;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 40px;
        }

        .table td,
        .table th {
            padding: 14px;
        }

        @media print {

            body {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .slip-container {
                border: none;
                padding: 0;
            }

        }
    </style>

</head>

<body>


    <div class="slip-container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-5">

            <div>

                <h2 class="fw-bold mb-1">

                    Payroll Management System

                </h2>

                <p class="text-muted mb-0">

                    PT. Ranma Digital Indonesia

                </p>

            </div>

            <div class="text-end">

                <h5 class="fw-bold">

                    SLIP GAJI

                </h5>

                <small class="text-muted">

                    <?= $data['periode'] ?>

                </small>

            </div>

        </div>


        <!-- IDENTITAS -->
        <div class="row mb-4">

            <div class="col-md-6 mb-3">

                <strong>NIK</strong>

                <p class="mb-0">

                    <?= $data['nik'] ?>

                </p>

            </div>

            <div class="col-md-6 mb-3">

                <strong>Nama Karyawan</strong>

                <p class="mb-0">

                    <?= $data['nama_karyawan'] ?>

                </p>

            </div>

            <div class="col-md-6 mb-3">

                <strong>Jabatan</strong>

                <p class="mb-0">

                    <?= $data['nama_jabatan'] ?>

                </p>

            </div>

            <div class="col-md-6 mb-3">

                <strong>Golongan</strong>

                <p class="mb-0">

                    <?= $data['nama_golongan'] ?>

                </p>

            </div>

        </div>


        <!-- TABLE -->
        <table class="table table-bordered align-middle">

            <tbody>

                <tr>

                    <th width="70%">

                        Gaji Pokok

                    </th>

                    <td>

                        Rp
                        <?= number_format($data['gaji_pokok'], 0, ',', '.') ?>

                    </td>

                </tr>


                <tr>

                    <th>

                        Tunjangan Jabatan

                    </th>

                    <td>

                        Rp
                        <?= number_format($data['tunjangan_jabatan'], 0, ',', '.') ?>

                    </td>

                </tr>


                <tr>

                    <th>

                        Tunjangan Golongan

                    </th>

                    <td>

                        Rp
                        <?= number_format($data['tunjangan_golongan'], 0, ',', '.') ?>

                    </td>

                </tr>


                <tr>

                    <th>

                        Bonus

                    </th>

                    <td>

                        Rp
                        <?= number_format($data['bonus'], 0, ',', '.') ?>

                    </td>

                </tr>


                <tr>

                    <th>

                        Potongan

                    </th>

                    <td>

                        Rp
                        <?= number_format($data['potongan'], 0, ',', '.') ?>

                    </td>

                </tr>


                <tr class="table-success">

                    <th class="fs-5">

                        Total Gaji

                    </th>

                    <td class="fw-bold fs-5">

                        Rp
                        <?= number_format($data['total_gaji'], 0, ',', '.') ?>

                    </td>

                </tr>

            </tbody>

        </table>


        <!-- FOOTER -->
        <div class="row mt-5">

            <div class="col-6">

                <small class="text-muted">

                    Dicetak pada:

                    <?= date('d F Y H:i') ?>

                </small>

            </div>

            <div class="col-6 text-end">

                <p class="mb-5">

                    Mengetahui,

                </p>

                <h6 class="fw-bold">

                    HR Payroll

                </h6>

            </div>

        </div>


        <!-- BUTTON -->
        <div class="text-center mt-5 no-print">

            <button onclick="window.print()" class="btn btn-primary px-4">

                Print Slip

            </button>

        </div>

    </div>

</body>

</html>

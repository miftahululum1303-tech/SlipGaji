<?php

/* ========================================
   VALIDASI SESSION
======================================== */

$idKaryawan = intval($_SESSION['id_karyawan'] ?? 0);

$idGaji = intval($_GET['id'] ?? 0);

if ($idKaryawan <= 0 || $idGaji <= 0) {
    echo "

    <script>

        alert(
            'Data tidak valid'
        );

        window.location =
            'index.php?page=slip_gaji';

    </script>

    ";

    exit();
}

/* ========================================
   AMBIL DATA SLIP
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

     AND

        tg.id_karyawan='$idKaryawan'

     LIMIT 1",
);

$data = mysqli_fetch_assoc($query);

/* ========================================
   VALIDASI DATA
======================================== */

if (!$data) {
    echo "

    <script>

        alert(
            'Slip gaji tidak ditemukan'
        );

        window.location =
            'index.php?page=slip_gaji';

    </script>

    ";

    exit();
}

/* ========================================
   GENERATE QR
======================================== */

include_once 'assets/phpqrcode/qrlib.php';

$qrText = 'SLIP-' . $data['id_gaji'];

/* ========================================
   DIRECTORY QR
======================================== */

$qrDirectory = 'assets/uploads/qrcode/';

/* ========================================
   BUAT FOLDER JIKA BELUM ADA
======================================== */

if (!is_dir($qrDirectory)) {
    mkdir($qrDirectory, 0777, true);
}

/* ========================================
   FILE QR
======================================== */

$filename = $qrDirectory . 'slip_' . $data['id_gaji'] . '.png';

/* ========================================
   GENERATE FILE QR
======================================== */

if (!file_exists($filename)) {
    QRcode::png($qrText, $filename, QR_ECLEVEL_L, 4);
}

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">

        <div>

            <h4 class="fw-bold mb-1">

                Detail Slip Gaji

            </h4>

            <p class="text-muted small mb-0">

                Informasi detail payroll karyawan

            </p>

        </div>

        <div class="d-flex gap-2">

            <!-- PRINT -->
            <button onclick="window.print()" class="btn btn-primary rounded-3">

                <i class="fa-solid fa-print me-2"></i>

                Print Slip

            </button>

            <!-- KEMBALI -->
            <a href="index.php?page=slip_gaji" class="btn btn-light rounded-3">

                Kembali

            </a>

        </div>

    </div>


    <!-- SLIP -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">


            <!-- COMPANY -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-4 border-bottom">

                <div>

                    <h3 class="fw-bold mb-1">

                        Payroll Management System

                    </h3>

                    <p class="text-muted mb-0">

                        PT. Ranma Digital Indonesia

                    </p>

                </div>

                <div class="text-md-end">

                    <small class="text-muted d-block">

                        Slip Gaji Karyawan

                    </small>

                    <h6 class="fw-bold mb-1">

                        SLIP-<?= str_pad($data['id_gaji'], 5, '0', STR_PAD_LEFT) ?>

                    </h6>

                    <small class="text-muted">

                        <?= date('d F Y', strtotime($data['tanggal_gaji'])) ?>

                    </small>

                </div>

            </div>


            <!-- IDENTITAS -->
            <div class="row g-4 mb-4">

                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">

                        NIK

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nik'] ?>

                    </h6>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">

                        Nama Karyawan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_karyawan'] ?>

                    </h6>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">

                        Jabatan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_jabatan'] ?>

                    </h6>

                </div>


                <div class="col-md-3">

                    <small class="text-muted d-block mb-1">

                        Golongan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $data['nama_golongan'] ?>

                    </h6>

                </div>

            </div>


            <!-- TABLE -->
            <div class="table-responsive mb-4">

                <table class="table align-middle">

                    <tbody>

                        <tr>

                            <th width="70%">

                                Gaji Pokok

                            </th>

                            <td class="fw-bold text-primary">

                                Rp
                                <?= number_format($data['gaji_pokok'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <tr>

                            <th>

                                Tunjangan Jabatan

                            </th>

                            <td class="fw-bold text-info">

                                Rp
                                <?= number_format($data['tunjangan_jabatan'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <tr>

                            <th>

                                Tunjangan Golongan

                            </th>

                            <td class="fw-bold text-success">

                                Rp
                                <?= number_format($data['tunjangan_golongan'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <tr>

                            <th>

                                Bonus

                            </th>

                            <td class="fw-bold text-success">

                                Rp
                                <?= number_format($data['bonus'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <tr>

                            <th>

                                Potongan

                            </th>

                            <td class="fw-bold text-danger">

                                Rp
                                <?= number_format($data['potongan'], 0, ',', '.') ?>

                            </td>

                        </tr>


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

            </div>


            <!-- QR + TTD -->
            <div class="row mt-5 pt-4 border-top signature-section">

                <!-- QR -->
                <div class="col-6 text-center">

                    <img src="<?= $filename ?>" class="img-fluid border rounded-4 p-2 bg-white" style="width:130px;">

                    <p class="small text-muted mt-2 mb-0">

                        QR Verification Slip Gaji

                    </p>

                </div>


                <!-- TTD -->
                <div class="col-6 text-center">

                    <p class="mb-5">

                        Mengetahui,

                    </p>

                    <h6 class="fw-bold text-decoration-underline mb-1">

                        Miftahul Ulum

                    </h6>

                    <small class="text-muted">

                        PT. Ranma Digital Indonesia

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

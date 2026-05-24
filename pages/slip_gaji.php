<?php

$id_karyawan = $_SESSION['id_karyawan'];

$sql = mysqli_query(
    $koneksi,
    "SELECT
        tg.*,

        k.nik,
        k.nama_karyawan,

        j.nama_jabatan,
        j.gaji_pokok,

        g.nama_golongan,
        g.tunjangan_golongan

     FROM transaksi_gaji tg

     INNER JOIN karyawan k
        ON tg.id_karyawan = k.id_karyawan

     INNER JOIN transaksi_jabatan tj
        ON k.id_karyawan = tj.id_karyawan

     INNER JOIN jabatan j
        ON tj.id_jabatan = j.id_jabatan

     INNER JOIN transaksi_golongan trg
        ON k.id_karyawan = trg.id_karyawan

     INNER JOIN golongan g
        ON trg.id_golongan = g.id_golongan

     WHERE tg.id_karyawan='$id_karyawan'

     ORDER BY tg.id_gaji DESC",
);
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 no-print">

    <div>

        <h4 class="fw-bold mb-1">
            <i class="fa-solid fa-file-invoice-dollar me-2 text-primary"></i>
            Slip Gaji Saya
        </h4>

        <p class="text-muted mb-0">
            Detail payroll dan riwayat gaji karyawan
        </p>

    </div>

    <div class="d-flex gap-2">

        <button onclick="window.print()" class="btn btn-dark rounded-3">
            <i class="fa-solid fa-print me-2"></i>
            Print Slip
        </button>

        <button class="btn btn-danger rounded-3">

            <i class="fa-solid fa-file-pdf me-2"></i>
            Download PDF

        </button>

    </div>

</div>

<?php if(mysqli_num_rows($sql) > 0) { ?>

<?php while($row = mysqli_fetch_array($sql)) { ?>
<div class="card card-premium border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">

            <div class="d-flex align-items-center gap-3">

                <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center"
                    style="width:70px;height:70px;">

                    <i class="fa-solid fa-money-check-dollar fs-2"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Payroll Management System
                    </h4>

                    <p class="text-muted mb-0">
                        PT. Ranma Digital Indonesia
                    </p>

                </div>

            </div>

            <div class="text-end">

                <small class="text-muted">
                    Slip Gaji Karyawan
                </small>

                <p class="mb-0 small text-muted">
                    No Slip :
                    SLIP-<?= str_pad($row['id_gaji'], 5, '0', STR_PAD_LEFT) ?>
                </p>

                <h6 class="fw-bold">
                    <?= date('d M Y') ?>
                </h6>

            </div>

        </div>

        <!-- HEADER -->
        <div class="row mb-4">

            <div class="col-md-4">

                <small class="text-muted">
                    NIK
                </small>

                <h6 class="fw-bold">
                    <?= $row['nik'] ?>
                </h6>

            </div>

            <div class="col-md-4">

                <small class="text-muted">
                    Nama Karyawan
                </small>

                <h6 class="fw-bold">
                    <?= $row['nama_karyawan'] ?>
                </h6>

            </div>

            <div class="col-md-4">

                <small class="text-muted">
                    Periode
                </small>

                <h6 class="fw-bold">
                    <?= $row['periode'] ?>
                </h6>

            </div>

        </div>

        <!-- TABEL GOLONGAN -->
        <h6 class="fw-bold mb-3">
            <i class="fa-solid fa-layer-group me-2"></i>
            Berdasarkan Golongan
        </h6>

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>
                    <th>Golongan</th>
                    <th width="30%">Nominal</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        <?= $row['nama_golongan'] ?>
                    </td>

                    <td class="fw-bold text-success">

                        Rp <?= number_format($row['tunjangan_golongan'], 0, ',', '.') ?>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- TABEL JABATAN -->
        <h6 class="fw-bold mb-3 mt-4">
            <i class="fa-solid fa-user-tie me-2"></i>
            Berdasarkan Jabatan
        </h6>

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>
                    <th>Jabatan</th>
                    <th width="30%">Nominal</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        <?= $row['nama_jabatan'] ?>
                    </td>

                    <td class="fw-bold text-primary">

                        Rp <?= number_format($row['gaji_pokok'], 0, ',', '.') ?>

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- RINGKASAN -->
        <div class="mt-4">

            <table class="table">

                <tr>

                    <th width="70%">
                        Bonus
                    </th>

                    <td class="text-success fw-bold">

                        Rp <?= number_format($row['bonus'], 0, ',', '.') ?>

                    </td>

                </tr>

                <tr>

                    <th>
                        Potongan
                    </th>

                    <td class="text-danger fw-bold">

                        Rp <?= number_format($row['potongan'], 0, ',', '.') ?>

                    </td>

                </tr>

                <tr class="table-success">

                    <th>
                        Total Gaji
                    </th>

                    <td class="fw-bold fs-5">

                        Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?>

                    </td>

                </tr>

            </table>

        </div>

    </div>

    <!-- QR + TTD -->
    <div class="row mt-4 pt-4 signature-section">

        <!-- QR -->
        <div class="col-6 text-center">

            <?php

            include_once 'assets/phpqrcode/qrlib.php';

            $qr_text = 'SLIP-' . $row['id_gaji'];

            $filename = 'assets/qrcode/slip_' . $row['id_gaji'] . '.png';

            if (!file_exists($filename)) {
                QRcode::png($qr_text, $filename, QR_ECLEVEL_L, 4);
            }

            ?>

            <img src="<?= $filename ?>" class="img-fluid border rounded-3 p-2 bg-white" style="width:120px;">

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

<?php } ?>

<?php } else { ?>

<div class="alert alert-warning rounded-4 border-0">

    <i class="fa-solid fa-circle-info me-2"></i>

    Belum ada data slip gaji.

</div>

<?php } ?>

<style media="print">
    .btn,
    .sidebar-premium,
    .navbar,
    footer,
    .footer,
    .main-footer,
    .content-footer,
    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    @page {
        size: A4;
        margin: 20px;
    }

    .card-premium {
        page-break-inside: avoid;
    }

    .signature-section {
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .card-body {
        page-break-inside: avoid;
    }
</style>

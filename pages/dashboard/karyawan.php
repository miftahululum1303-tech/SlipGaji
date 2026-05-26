<?php

$id_karyawan = $_SESSION['id_karyawan'] ?? 0;

/* ========================================
   DATA KARYAWAN
======================================== */

$queryKaryawan = mysqli_query(
    $koneksi,

    "SELECT *
     FROM karyawan
     WHERE id_karyawan='$id_karyawan'",
);

$karyawan = mysqli_fetch_assoc($queryKaryawan);

/* ========================================
   TOTAL SLIP GAJI
======================================== */

$totalSlip = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,

        "SELECT COUNT(*) as total
         FROM transaksi_gaji
         WHERE id_karyawan='$id_karyawan'",
    ),
)['total'];

/* ========================================
   TOTAL GAJI
======================================== */

$totalGaji =
    mysqli_fetch_assoc(
        mysqli_query(
            $koneksi,

            "SELECT SUM(total_gaji) as total
         FROM transaksi_gaji
         WHERE id_karyawan='$id_karyawan'",
        ),
    )['total'] ?? 0;

/* ========================================
   SLIP TERAKHIR
======================================== */

$querySlip = mysqli_query(
    $koneksi,

    "SELECT *
     FROM transaksi_gaji
     WHERE id_karyawan='$id_karyawan'
     ORDER BY id_gaji DESC
     LIMIT 1"
);

$slip = mysqli_fetch_assoc($querySlip);

?>


<div class="dashboard-wrapper px-4 pb-4">

    <!-- ========================================
         WELCOME
    ======================================== -->

    <div class="card-dashboard p-4">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

            <div>

                <h3 class="dashboard-title mb-1">

                    Selamat Datang,
                    <?= $karyawan['nama_karyawan'] ?? 'Karyawan' ?> 👋

                </h3>

                <p class="dashboard-subtitle mb-0">

                    Berikut informasi payroll dan slip gaji Anda.

                </p>

            </div>

            <div class="badge-clock">

                <i class="fa-regular fa-calendar me-2"></i>

                <?= date('d F Y') ?>

            </div>

        </div>

    </div>


    <!-- ========================================
         STATISTIC
    ======================================== -->

    <div class="row g-4">

        <!-- TOTAL SLIP -->
        <div class="col-md-6 col-xl-4">

            <div class="card-dashboard border-accent-primary p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Slip Gaji

                        </p>

                        <h3 class="fw-bold mb-0" data-counter="<?= $totalSlip ?>">

                            0

                        </h3>

                    </div>

                    <div class="icon-shape bg-primary bg-opacity-10 text-primary">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- TOTAL PENDAPATAN -->
        <div class="col-md-6 col-xl-4">

            <div class="card-dashboard border-accent-success p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Pendapatan

                        </p>

                        <h4 class="fw-bold mb-0">

                            Rp
                            <?= number_format($totalGaji, 0, ',', '.') ?>

                        </h4>

                    </div>

                    <div class="icon-shape bg-success bg-opacity-10 text-success">

                        <i class="fa-solid fa-wallet"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- STATUS -->
        <div class="col-md-6 col-xl-4">

            <div class="card-dashboard border-accent-warning p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Status Akun

                        </p>

                        <h5 class="fw-bold mb-0 text-success">

                            Aktif

                        </h5>

                    </div>

                    <div class="icon-shape bg-warning bg-opacity-10 text-warning">

                        <i class="fa-solid fa-circle-check"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================
         SLIP TERAKHIR
    ======================================== -->

    <div class="card-dashboard p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h5 class="fw-bold mb-1">

                    Slip Gaji Terakhir

                </h5>

                <p class="text-muted small mb-0">

                    Informasi payroll terbaru Anda

                </p>

            </div>

            <a href="index.php?page=slip_gaji" class="btn btn-primary rounded-3">

                <i class="fa-solid fa-eye me-2"></i>

                Lihat Slip

            </a>

        </div>

        <?php if ($slip) { ?>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Periode</th>

                        <th>Bonus</th>

                        <th>Potongan</th>

                        <th>Total Gaji</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>

                            <?= $slip['periode'] ?>

                        </td>

                        <td>

                            Rp
                            <?= number_format($slip['bonus'], 0, ',', '.') ?>

                        </td>

                        <td>

                            Rp
                            <?= number_format($slip['potongan'], 0, ',', '.') ?>

                        </td>

                        <td class="fw-bold text-success">

                            Rp
                            <?= number_format($slip['total_gaji'], 0, ',', '.') ?>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <?php } else { ?>

        <div class="alert alert-info rounded-4 border-0 mb-0">

            <i class="fa-solid fa-circle-info me-2"></i>

            Belum ada data slip gaji.

        </div>

        <?php } ?>

    </div>


    <!-- ========================================
         PROFILE INFO
    ======================================== -->

    <div class="card-dashboard p-4">

        <h5 class="fw-bold mb-4">

            Informasi Karyawan

        </h5>

        <div class="row g-4">

            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        Nama Karyawan

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $karyawan['nama_karyawan'] ?? '-' ?>

                    </h6>

                </div>

            </div>

            <div class="col-md-6">

                <div class="border rounded-4 p-3 h-100">

                    <small class="text-muted d-block mb-1">

                        NIK

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= $karyawan['nik'] ?? '-' ?>

                    </h6>

                </div>

            </div>

        </div>

    </div>

</div>

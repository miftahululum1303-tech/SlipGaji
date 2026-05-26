<?php

/* ========================================
   TOTAL DATA
======================================== */

$total_karyawan = mysqli_fetch_assoc(mysqli_query($koneksi, 'SELECT COUNT(*) as total FROM karyawan'))['total'];

$total_golongan = mysqli_fetch_assoc(mysqli_query($koneksi, 'SELECT COUNT(*) as total FROM golongan'))['total'];

$total_jabatan = mysqli_fetch_assoc(mysqli_query($koneksi, 'SELECT COUNT(*) as total FROM jabatan'))['total'];

$total_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, 'SELECT COUNT(*) as total FROM transaksi_gaji'))['total'];

/* ========================================
   DATA CHART
======================================== */

$chartQuery = mysqli_query(
    $koneksi,
    "SELECT periode,
            SUM(total_gaji) as total
     FROM transaksi_gaji
     GROUP BY periode
     ORDER BY periode ASC",
);

$chartLabels = [];
$chartTotals = [];

while ($chart = mysqli_fetch_assoc($chartQuery)) {
    $chartLabels[] = $chart['periode'];

    $chartTotals[] = (int) $chart['total'];
}

?>


<div class="dashboard-wrapper px-4 pb-4">

    <!-- ========================================
         WELCOME
    ======================================== -->

    <div class="card-dashboard p-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h3 class="dashboard-title mb-1">

                    Selamat Datang, Admin 👋

                </h3>

                <p class="dashboard-subtitle mb-0">

                    Kelola sistem payroll perusahaan dengan mudah dan efisien.

                </p>

            </div>

            <div class="badge-clock">

                <i class="fa-regular fa-calendar me-2"></i>

                <?= date('d F Y') ?>

            </div>

        </div>

    </div>


    <!-- ========================================
         STATISTIC CARD
    ======================================== -->

    <div class="row g-4">

        <!-- KARYAWAN -->
        <div class="col-md-6 col-xl-3">

            <div class="card-dashboard border-accent-primary p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Karyawan

                        </p>

                        <h3 class="fw-bold mb-0" data-counter="<?= $total_karyawan ?>">

                            0

                        </h3>

                    </div>

                    <div class="icon-shape bg-primary bg-opacity-10 text-primary">

                        <i class="fa-solid fa-users"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- GOLONGAN -->
        <div class="col-md-6 col-xl-3">

            <div class="card-dashboard border-accent-success p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Golongan

                        </p>

                        <h3 class="fw-bold mb-0" data-counter="<?= $total_golongan ?>">

                            0

                        </h3>

                    </div>

                    <div class="icon-shape bg-success bg-opacity-10 text-success">

                        <i class="fa-solid fa-layer-group"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- JABATAN -->
        <div class="col-md-6 col-xl-3">

            <div class="card-dashboard border-accent-warning p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Jabatan

                        </p>

                        <h3 class="fw-bold mb-0" data-counter="<?= $total_jabatan ?>">

                            0

                        </h3>

                    </div>

                    <div class="icon-shape bg-warning bg-opacity-10 text-warning">

                        <i class="fa-solid fa-briefcase"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- TRANSAKSI -->
        <div class="col-md-6 col-xl-3">

            <div class="card-dashboard border-accent-primary p-4 h-100">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="text-muted small mb-2">

                            Total Payroll

                        </p>

                        <h3 class="fw-bold mb-0" data-counter="<?= $total_transaksi ?>">

                            0

                        </h3>

                    </div>

                    <div class="icon-shape bg-info bg-opacity-10 text-info">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================
         CHART
    ======================================== -->

    <div class="card-dashboard p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h5 class="fw-bold mb-1">

                    Grafik Payroll

                </h5>

                <p class="text-muted small mb-0">

                    Statistik total pengeluaran gaji

                </p>

            </div>

        </div>

        <div class="chart-container">

            <canvas id="payrollChart" data-labels='<?= json_encode($chartLabels) ?>'
                data-totals='<?= json_encode($chartTotals) ?>'>
            </canvas>

        </div>

    </div>


    <!-- ========================================
         INFO SYSTEM
    ======================================== -->

    <div class="row g-4">

        <div class="col-lg-6">

            <div class="card-dashboard p-4 h-100">

                <h5 class="fw-bold mb-3">

                    Informasi Sistem

                </h5>

                <div class="d-flex flex-column gap-3">

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Status Server

                        </span>

                        <span class="badge bg-success">

                            Active

                        </span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Database

                        </span>

                        <span class="badge bg-primary">

                            Connected

                        </span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Sistem

                        </span>

                        <span class="badge bg-info">

                            Payroll Management

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card-dashboard p-4 h-100">

                <h5 class="fw-bold mb-3">

                    Aktivitas Hari Ini

                </h5>

                <div class="d-flex flex-column gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <div class="icon-shape bg-primary bg-opacity-10 text-primary">

                            <i class="fa-solid fa-user-plus"></i>

                        </div>

                        <div>

                            <h6 class="mb-0">

                                Sistem Payroll Aktif

                            </h6>

                            <small class="text-muted">

                                <?= date('d F Y H:i') ?> WIB

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

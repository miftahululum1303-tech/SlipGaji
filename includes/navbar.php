<?php

$pageTitle = 'Dashboard';

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    $titles = [
        'karyawan' => 'Data Karyawan',
        'golongan' => 'Data Golongan',
        'jabatan' => 'Data Jabatan',

        'transaksi_golongan' => 'Transaksi Golongan',
        'transaksi_jabatan' => 'Transaksi Jabatan',
        'transaksi_gaji' => 'Transaksi Gaji',

        'laporan' => 'Laporan Payroll',

        'slip_gaji' => 'Slip Gaji Saya',

        'profil' => 'Profil Saya',
    ];

    $pageTitle = $titles[$page] ?? 'Dashboard';
}

?>


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom px-4 py-3">

    <div class="container-fluid p-0">

        <!-- LEFT -->
        <div>

            <h4 class="fw-bold mb-1 text-dark">

                <?= $pageTitle ?>

            </h4>

            <small class="text-muted">

                Payroll Management System

            </small>

        </div>


        <!-- RIGHT -->
        <div class="d-flex align-items-center gap-3">

            <!-- CLOCK -->
            <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">

                <i class="fa-solid fa-clock me-2 text-primary"></i>

                <span id="liveClock">
                    <?= date('H:i') ?>
                </span>

            </div>


            <!-- USER -->
            <div class="dropdown">

                <button class="btn btn-light border rounded-pill px-3 dropdown-toggle" data-bs-toggle="dropdown">

                    <i class="fa-solid fa-user-circle me-2 text-primary"></i>

                    <?= ucfirst($_SESSION['role']) ?>

                </button>

                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2">

                    <li>

                        <a class="dropdown-item rounded-3" href="index.php?page=profil">

                            <i class="fa-solid fa-user me-2"></i>

                            Profil Saya

                        </a>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <a class="dropdown-item text-danger rounded-3" href="auth/logout.php">

                            <i class="fa-solid fa-right-from-bracket me-2"></i>

                            Logout

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

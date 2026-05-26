<?php

$role = $_SESSION['role'] ?? '';

$currentPage = $_GET['page'] ?? '';

?>

<div class="sidebar-premium vh-100 shadow d-flex flex-column" id="sidebar-wrapper">

    <div class="sidebar-brand">
        <div class="brand-logo">

            <img src="assets/images/logo.png" alt="Logo Payroll">

        </div>

        <div class="brand-text">

            <h5>
                PAYROLL
                <br>
                SYSTEM
            </h5>

            <small>
                Miftahul Ulum
            </small>

        </div>
    </div>

    <div class="flex-grow-1 overflow-auto py-3 px-2 sidebar-scroll">
        <ul class="nav flex-column gap-1">

            <li class="nav-item">
                <a class="nav-link <?= empty($currentPage) ? 'active' : '' ?>" href="index.php">
                    <i class="fa-solid fa-chart-pie nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'profil' ? 'active' : '' ?>"
                    href="index.php?page=profil">
                    <i class="fa-solid fa-user-gear nav-icon"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            <?php if ($role == 'karyawan') { ?>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'slip_gaji' ? 'active' : '' ?>"
                    href="index.php?page=slip_gaji">
                    <i class="fa-solid fa-file-invoice-dollar nav-icon"></i>
                    <span>Slip Gaji Saya</span>
                </a>
            </li>
            <?php } ?>

            <?php if ($role == 'admin') { ?>
            <li class="sidebar-title mt-3 mb-2">
                MASTER DATA
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $currentPage == 'karyawan' ? 'active' : '' ?>" href="index.php?page=karyawan">
                    <i class="fa-solid fa-users nav-icon"></i>
                    <span>Data Karyawan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'golongan' ? 'active' : '' ?>"
                    href="index.php?page=golongan">
                    <i class="fa-solid fa-layer-group nav-icon"></i>
                    <span>Data Golongan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'jabatan' ? 'active' : '' ?>"
                    href="index.php?page=jabatan">
                    <i class="fa-solid fa-briefcase nav-icon"></i>
                    <span>Data Jabatan</span>
                </a>
            </li>
            <?php } ?>

            <?php if ($role == 'admin') { ?>
            <li class="sidebar-title mt-4 mb-2">
                TRANSAKSI
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'transaksi_golongan' ? 'active' : '' ?>"
                    href="index.php?page=transaksi_golongan">
                    <i class="fa-solid fa-money-bill-wave nav-icon"></i>
                    <span>Transaksi Golongan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'transaksi_jabatan' ? 'active' : '' ?>"
                    href="index.php?page=transaksi_jabatan">
                    <i class="fa-solid fa-wallet nav-icon"></i>
                    <span>Transaksi Jabatan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'transaksi_gaji' ? 'active' : '' ?>"
                    href="index.php?page=transaksi_gaji">
                    <i class="fa-solid fa-file-invoice-dollar nav-icon"></i>
                    <span>Transaksi Gaji</span>
                </a>
            </li>
            <?php } ?>

            <?php if ($role == 'admin') { ?>
            <li class="sidebar-title mt-4 mb-2">
                LAPORAN
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'laporan' ? 'active' : '' ?>"
                    href="index.php?page=laporan">
                    <i class="fa-solid fa-file-waveform nav-icon"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>

    <div class="p-3 border-top border-secondary border-opacity-25">
        <a class="nav-link text-danger d-flex align-items-center gap-2" href="auth/logout.php"
            onclick="return confirm('Yakin ingin logout?')">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

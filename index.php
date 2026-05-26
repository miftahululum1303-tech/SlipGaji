<?php

/* ========================================
   START SESSION
======================================== */

session_start();

/* ========================================
   VALIDASI LOGIN
======================================== */

if (!isset($_SESSION['login'])) {
    header('Location: auth/login.php');

    exit();
}

/* ========================================
   KONEKSI DATABASE
======================================== */

include 'config/koneksi.php';

/* ========================================
   LAYOUT
======================================== */

include 'includes/header.php';

include 'includes/sidebar.php';

include 'includes/navbar.php';

?>


<!-- ========================================
     CONTENT
======================================== -->

<main class="content-wrapper">

    <div class="container-fluid p-4">


        <?php

        /* ========================================
           ROUTING PAGE
        ======================================== */

        $page = trim($_GET['page'] ?? '');

        /* ========================================
           DASHBOARD DEFAULT
        ======================================== */

        if (empty($page)) {
            $role = $_SESSION['role'] ?? '';

            /* ========================================
               ADMIN
            ======================================== */

            if ($role == 'admin') {
                include 'pages/dashboard/admin.php';
            }
            /* ========================================
               KARYAWAN
            ======================================== */ elseif ($role == 'karyawan') {
                include 'pages/dashboard/karyawan.php';
            }
            /* ========================================
               INVALID ROLE
            ======================================== */ else {
                include 'pages/errors/403.php';
            }
        }
        /* ========================================
           ROUTING MANUAL
        ======================================== */ else {
            $routes = [
                /* DASHBOARD */
                'dashboard' => 'pages/dashboard/admin.php',

                /* MASTER DATA */
                'karyawan' => 'pages/karyawan/index.php',

                'golongan' => 'pages/golongan/index.php',

                'jabatan' => 'pages/jabatan/index.php',

                /* TRANSAKSI */
                'transaksi_golongan' => 'pages/transaksi/golongan/index.php',

                'transaksi_jabatan' => 'pages/transaksi/jabatan/index.php',

                'transaksi_gaji' => 'pages/transaksi/gaji/index.php',

                'detail_gaji' => 'pages/transaksi/gaji/detail.php',

                /* LAPORAN */
                'laporan' => 'pages/laporan/index.php',

                /* SLIP GAJI */
                'slip_gaji' => 'pages/slip_gaji/index.php',

                'detail_slip' => 'pages/slip_gaji/detail.php',

                /* PROFILE */
                'profil' => 'pages/profil/index.php',

                /* LAPORAN */
                'laporan' => 'pages/laporan/laporan.php',
            ];

            /* ========================================
               VALIDASI ROUTE
            ======================================== */

            if (array_key_exists($page, $routes)) {
                include $routes[$page];
            }
            /* ========================================
               404
            ======================================== */ else {
                include 'pages/errors/404.php';
            }
        }

        ?>

    </div>

</main>


<?php

/* ========================================
   FOOTER
======================================== */

include 'includes/footer.php';

?>

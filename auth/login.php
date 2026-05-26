<?php
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: ../index.php');
    } else {
        header('Location: ../karyawan.php');
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Payroll System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Auth CSS -->
    <link rel="stylesheet" href="../assets/css/auth.css">

</head>

<body class="auth-page">

    <div class="auth-card">

        <!-- HEADER -->
        <div class="auth-header">

            <div class="auth-logo">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>

            <h1 class="auth-title">
                Payroll System
            </h1>

            <p class="auth-subtitle">
                Sistem Penggajian Karyawan
            </p>

        </div>

        <!-- BODY -->
        <div class="auth-body">

            <?php if (isset($_GET['logout'])) { ?>

            <div class="alert alert-success auth-alert">

                <i class="fa-solid fa-circle-check me-2"></i>

                Berhasil logout dari sistem

            </div>

            <?php } ?>

            <?php if (isset($_GET['error'])) { ?>

            <div class="alert alert-danger auth-alert">

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                <?php

                if ($_GET['error'] == 'empty') {
                    echo 'Username dan password wajib diisi';
                } elseif ($_GET['error'] == 'password') {
                    echo 'Password yang dimasukkan salah';
                } elseif ($_GET['error'] == 'username') {
                    echo 'Username tidak ditemukan';
                } else {
                    echo 'Terjadi kesalahan login';
                }

                ?>

            </div>

            <?php } ?>

            <form action="proses_login.php" method="POST" class="auth-form">

                <!-- USERNAME -->
                <div class="mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-user"></i>

                        </span>

                        <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                            required>

                    </div>

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-lock"></i>

                        </span>

                        <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                            required>

                    </div>

                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-primary btn-auth w-100">

                    <i class="fa-solid fa-right-to-bracket me-2"></i>

                    Masuk ke Dashboard

                </button>

            </form>

            <!-- FOOTER -->
            <div class="auth-footer">

                © <?= date('Y') ?>
                Payroll Management System

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

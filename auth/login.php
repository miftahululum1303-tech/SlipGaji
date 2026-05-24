<?php
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: ../index.php');
    } else {
        header('Location: ../karyawan.php');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Payroll System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f6; /* Warna latar belakang dashboard */
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-header {
            background: #2c3e50; /* Warna sidebar dashboard Anda */
            color: white;
            padding: 40px;
            text-align: center;
        }
        .btn-login {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: #34495e;
            color: white;
        }
        .form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fa-solid fa-lock fa-3x mb-3"></i>
                        <h4>Payroll System</h4>
                        <p class="mb-0 opacity-75">Silakan masuk untuk melanjutkan</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label class="fw-bold mb-1">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="fw-bold mb-1">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-login w-100 rounded-pill">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Payroll System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            /* Perubahan Background: Gradasi premium dengan kombinasi pola geometris halus */
            background: radial-gradient(circle at 10% 20%, rgba(215, 223, 252, 0.7) 0%, rgba(242, 246, 252, 0.7) 90%),
                        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill='%232c3e50' fill-opacity='0.02'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm56-76c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z'/%3E%3C/g%3E%3C/svg%3E");
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        /* Ornamen gelombang tambahan di background luar */
        body::before {
            content: "";
            position: absolute;
            width: 800px;
            height: 800px;
            border-radius: 43% 57% 41% 59% / 57% 45% 55% 43%;
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.05) 0%, rgba(52, 152, 219, 0.05) 100%);
            top: -200px;
            left: -200px;
            z-index: -1;
            animation: rotateBg 25s linear infinite;
        }

        @keyframes rotateBg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 920px;
            padding: 15px;
            z-index: 2;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(44, 62, 80, 0.12);
            background: #ffffff;
        }

        /* Bagian Kiri Card: Tetap mengusung tema gelap bawaanmu */
        .login-illustration {
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 45px;
            color: white;
            position: relative;
        }

        /* Perbaikan Gambar: Menggunakan ikon SVG finansial/keamanan terpercaya yang stabil */
        .illustration-box {
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: float 4s ease-in-out infinite;
        }

        .illustration-box i {
            color: #5dade2;
            text-shadow: 0 0 20px rgba(93, 173, 226, 0.5);
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* Bagian Kanan Card */
        .login-form-section {
            padding: 55px 45px;
        }

        .brand-title {
            color: #2c3e50;
            font-weight: 700;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #a0aec0;
        }

        .form-control {
            border-left: none;
            padding: 11px 14px;
        }

        .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #2c3e50;
        }

        .btn-login {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #1a252f;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
        }

        @media (max-width: 768px) {
            .login-illustration {
                display: none;
            }
            .login-form-section {
                padding: 40px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="card login-card">
            <div class="row g-0">

                <div class="col-md-6 login-illustration text-center">
                    <div class="illustration-box">
                        <i class="fa-solid fa-file-invoice-dollar fa-5x"></i>
                    </div>

                    <h4 class="fw-bold mb-2">Sistem Penggajian Online</h4>
                    <p class="small opacity-75 text-center px-2 mb-0" style="line-height: 1.6;">
                        Kelola data kehadiran, bonus, dan slip gaji karyawan dengan praktis dan aman.
                    </p>
                </div>

                <div class="col-md-6 login-form-section">
                    <div class="mb-4">
                        <h3 class="brand-title mb-1">Payroll System</h3>
                        <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                    </div>

                    <form action="proses_login.php" method="POST">
                        <div class="mb-3">
                            <label class="fw-semibold text-secondary small mb-2">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold text-secondary small mb-2">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 rounded-3">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk ke Dashboard
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>

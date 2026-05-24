<?php
// Memuat konfigurasi database utama
include 'config/koneksi.php';

// Memuat komponen tata letak atas (Navbar & Meta Tags)
include 'includes/header.php';

// Memuat komponen menu navigasi samping
include 'includes/sidebar.php';
?>

<main class="content-wrapper d-flex flex-column bg-light bg-opacity-50" style="min-height: 100vh;">
    <div class="container-fluid p-4 flex-grow-1">
        <?php
        // Logika Dynamic Page Loader berbasis parameter query 'page'
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $file = "pages/" . $page . ".php";

            // Validasi keberadaan file fisik di dalam folder pages/
            if (file_exists($file)) {
                include $file;
            } else {
                echo "
                <div class='card border-0 shadow-sm p-5 text-center rounded-3'>
                    <div class='text-danger mb-3'>
                        <i class='fa-solid fa-triangle-exclamation display-1'></i>
                    </div>
                    <h4 class='fw-bold text-dark'>Halaman Tidak Ditemukan!</h4>
                    <p class='text-muted small'>Mohon periksa kembali URL parameter atau ketersediaan file modul Anda.</p>
                    <div class='mt-2'>
                        <a href='index.php' class='btn btn-primary btn-sm fw-bold px-3 shadow-sm rounded-pill'>
                            <i class='fa-solid fa-arrow-left me-2'></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>";
            }
        } else {
            // =================================================================
            // HALAMAN DEFAULT: DASHBOARD UTAMA (DESAIN PREMIUM & MODERN)
            // =================================================================
            ?>
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-black text-dark mb-1 letter-spacing-tight" style="font-weight: 800;">Dashboard Utama</h4>
                    <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                        <i class="fa-solid fa-circle text-success fs-smaller animation-pulse"></i> 
                        Selamat datang kembali di Payroll System.
                    </p>
                </div>
                <div class="badge bg-white text-dark border px-3 py-2.5 rounded-pill shadow-sm d-flex align-items-center gap-2 fw-bold">
                    <i class="fa-solid fa-calendar-day text-primary"></i>
                    <span id="liveClock"><?= date('H:i'); ?> WIB</span>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative rounded-3 border-start border-primary border-4 card-dashboard">
                        <div class="card-body p-4 position-relative z-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 text-secondary text-uppercase fw-bold tracking-wider" style="font-size: 11px; letter-spacing: 1px;">Karyawan Aktif</h6>
                                    <?php
                                    $get_kry = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan WHERE status='Aktif'");
                                    $data_kry = mysqli_fetch_assoc($get_kry);
                                    ?>
                                    <h3 class="mb-0 fw-black text-dark" style="font-weight: 800;"><?= $data_kry['total'] ?? 0; ?> <span class="fs-6 fw-normal text-muted">Orang</span></h3>
                                </div>
                                <div class="icon-shape bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="fa-solid fa-users fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative rounded-3 border-start border-success border-4 card-dashboard">
                        <div class="card-body p-4 position-relative z-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 text-secondary text-uppercase fw-bold tracking-wider" style="font-size: 11px; letter-spacing: 1px;">Alokasi Gaji Bulan Ini</h6>
                                    <?php
$current_month = date('Y-m');

// Cek apakah tabel 'gaji' ada sebelum melakukan query
$check_table = mysqli_query($koneksi, "SHOW TABLES LIKE 'gaji'");
if (mysqli_num_rows($check_table) > 0) {
    $get_gaji = mysqli_query($koneksi, "SELECT SUM(total_gaji) as total FROM gaji WHERE bulan_tahun='$current_month'");
    $data_gaji = mysqli_fetch_assoc($get_gaji);
    $total_gaji = $data_gaji['total'] ?? 0;
} else {
    $total_gaji = 0; // Set default jika tabel belum ada
}
?>

<!-- Tampilan HTML -->
<h3 class="mb-0 fw-black text-dark" style="font-weight: 800;">Rp <?= number_format($total_gaji, 0, ',', '.'); ?></h3>
                                </div>
                                <div class="icon-shape bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i class="fa-solid fa-wallet fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative rounded-3 border-start border-warning border-4 card-dashboard">
                        <div class="card-body p-4 position-relative z-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 text-secondary text-uppercase fw-bold tracking-wider" style="font-size: 11px; letter-spacing: 1px;">Status Sinkronisasi</h6>
                                    <h3 class="mb-0 fw-black text-dark" style="font-weight: 800;">Normal / <span class="text-success fs-5 fw-bold">Aman</span></h3>
                                </div>
                                <div class="icon-shape bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="fa-solid fa-square-check fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="p-2 bg-primary bg-opacity-10 rounded-2 text-primary">
                                    <i class="fa-solid fa-chart-area"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Tren Pengeluaran Kas Operasional</h5>
                                    <p class="text-muted small m-0">Visualisasi real-time alokasi payroll tahunan.</p>
                                </div>
                            </div>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill font-monospace small">Tahun Fiskal <?= date('Y'); ?></span>
                        </div>
                        <div class="card-body px-4 pb-4 pt-2">
                            <div style="position: relative; height:320px; width:100%">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</main>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .letter-spacing-tight {
        letter-spacing: -0.5px;
    }
    .fs-smaller {
        font-size: 8px;
    }
    .animation-pulse {
        animation: pulse-animation 2s infinite;
    }
    @keyframes pulse-animation {
        0% { opacity: 0.4; }
        50% { opacity: 1; }
        100% { opacity: 0.4; }
    }
    .card-dashboard {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-dashboard:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important;
    }
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('liveClock').textContent = hours + ':' + minutes + ' WIB';
    }
    setInterval(updateClock, 1000);
</script>

<?php 
// Memuat komponen kaki halaman (Footer, JQuery, Bootstrap, & DataTables Script)
include 'includes/footer.php'; 
?>
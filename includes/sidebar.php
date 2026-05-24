<div class="sidebar-premium vh-100 shadow d-flex flex-column" id="sidebar-wrapper">
    
    <div class="brand-wrapper p-4 border-bottom border-secondary border-opacity-25 d-flex align-items-center gap-2">
        <div class="p-2 bg-primary bg-opacity-20 rounded-3 text-primary animate-pulse">
            <i class="fa-solid fa-money-check-dollar fs-5"></i>
        </div>
        <div>
            <h6 class="fw-bold text-white mb-0 text-uppercase tracking-wider" style="font-size: 12px; letter-spacing: 0.5px;">Payroll System</h6>
            <small class="text-secondary" style="font-size: 10px;">Miftahul Ulum</small>
        </div>
    </div>

    <div class="flex-grow-1 overflow-auto py-3 px-2">
        <ul class="nav flex-column gap-1">
            
            <li class="nav-item">
                <a class="nav-link <?= (!isset($_GET['page'])) ? 'active' : ''; ?>" href="index.php">
                    <i class="fa-solid fa-chart-pie nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'profil') ? 'active' : ''; ?>" href="index.php?page=profil">
                    <i class="fa-solid fa-user-gear nav-icon"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" href="#menuMaster" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-database nav-icon"></i>
                        <span>Master Data</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon small text-secondary"></i>
                </a>
                <div class="collapse <?= (isset($_GET['page']) && in_array($_GET['page'], ['karyawan','golongan','jabatan'])) ? 'show' : ''; ?>" id="menuMaster">
                    <ul class="nav flex-column ms-4 pt-1 gap-1 sub-menu">
                        <li><a class="nav-link-sub" href="index.php?page=karyawan"><i class="fa-solid fa-circle-dot me-2"></i>Data Karyawan</a></li>
                        <li><a class="nav-link-sub" href="index.php?page=golongan"><i class="fa-solid fa-circle-dot me-2"></i>Data Golongan</a></li>
                        <li><a class="nav-link-sub" href="index.php?page=jabatan"><i class="fa-solid fa-circle-dot me-2"></i>Data Jabatan</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" href="#menuTransaksi" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-wallet nav-icon"></i>
                        <span>Transaksi</span>
                    </div>
                    <i class="fa-solid fa-chevron-down arrow-icon small text-secondary"></i>
                </a>
                <div class="collapse <?= (isset($_GET['page']) && in_array($_GET['page'], ['transaksi_golongan','transaksi_jabatan'])) ? 'show' : ''; ?>" id="menuTransaksi">
                    <ul class="nav flex-column ms-4 pt-1 gap-1 sub-menu">
                        <li><a class="nav-link-sub" href="index.php?page=transaksi_golongan"><i class="fa-solid fa-circle-dot me-2"></i>Transaksi Golongan</a></li>
                        <li><a class="nav-link-sub" href="index.php?page=transaksi_jabatan"><i class="fa-solid fa-circle-dot me-2"></i>Transaksi Jabatan</a></li>
						<li><a class="nav-link-sub" href="index.php?page=transaksi_gaji"><i class="fa-solid fa-circle-dot me-2"></i>Transaksi Gaji</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>

<style>
/* Kontainer Utama Sidebar */
.sidebar-premium {
    width: 260px;
    background-color: #1a233a !important; /* Warna Dark Navy Premium */
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    transition: all 0.3s ease;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
}

/* Pengaturan Scrollbar Halus di Sisi Sidebar */
.sidebar-premium .overflow-auto {
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
}
.sidebar-premium .overflow-auto::-webkit-scrollbar {
    width: 4px;
}
.sidebar-premium .overflow-auto::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

/* Desain Dasar Tautan Menu Utama */
.sidebar-premium .nav-link {
    color: #a3b1cc !important;
    font-weight: 500;
    font-size: 14px;
    padding: 11px 16px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.25s ease-in-out;
    margin: 2px 8px;
}

/* Efek Hover Menu Utama */
.sidebar-premium .nav-link:hover {
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.04);
}

/* Desain Menu Saat Berstatus Aktif (Sedang Dibuka) */
.sidebar-premium .nav-link.active {
    color: #ffffff !important;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important; /* Gradasi Biru Modern */
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    font-weight: 600;
}

/* Warna Ikon Menu */
.sidebar-premium .nav-icon {
    font-size: 16px;
    width: 20px;
    text-align: center;
    opacity: 0.8;
    transition: transform 0.2s ease;
}
.sidebar-premium .nav-link:hover .nav-icon {
    transform: scale(1.1);
    opacity: 1;
}

/* Tampilan Sub-Menu Dropdown (Anak Menu) */
.sidebar-premium .nav-link-sub {
    color: #8c9cb8 !important;
    font-size: 13px;
    padding: 8px 16px;
    display: block;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
    margin: 1px 12px 1px 4px;
}
.sidebar-premium .nav-link-sub:hover {
    color: #38bdf8 !important; /* Warna cyan cerah saat sub-menu di-hover */
    background-color: rgba(56, 189, 248, 0.06);
    padding-left: 20px; /* Efek bergeser sedikit ke kanan */
}

/* Rotasi Otomatis Ikon Panah Dropdown Bootstrap */
.sidebar-premium .nav-link:not(.collapsed) .arrow-icon {
    transform: rotate(180deg);
    color: #fff !important;
}
.sidebar-premium .arrow-icon {
    transition: transform 0.2s ease;
}
</style>
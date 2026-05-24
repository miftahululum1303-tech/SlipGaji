<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- CDN Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root { --primary-color: #3e7ccb; --sidebar-width: 260px; --sidebar-collapsed-width: 70px; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        /* Navbar */
        .navbar { background: #fff; border-bottom: 1px solid #e0e0e0; z-index: 1030; height: 60px; }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 800; letter-spacing: 1px; }
        
        /* Sidebar */
        #sidebar { 
            width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; 
            padding-top: 70px; background: #fff; transition: all 0.3s ease; border-right: 1px solid #e0e0e0; z-index: 1020; 
        }
        #sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .nav-link { 
            color: #4b4f56; padding: 12px 20px; display: flex; align-items: center; 
            transition: 0.2s; border-radius: 8px; margin: 4px 10px;
        }
        .nav-link:hover, .nav-link.active { background: #f0f2f5; color: var(--primary-color); }
        .nav-link i { width: 30px; font-size: 1.1rem; }
        .sidebar-text { transition: opacity 0.3s; white-space: nowrap; }
        .collapsed .sidebar-text, .collapsed .dropdown-toggle::after { display: none; }
        
        /* Content Wrapper */
        .content-wrapper { margin-left: var(--sidebar-width); transition: all 0.3s ease; padding-top: 5px; min-height: 100vh; }
        .content-wrapper.expanded { margin-left: var(--sidebar-collapsed-width); }
        
        /* Utility */
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .card { border-radius: 12px; }
        @media (max-width: 768px) {
            #sidebar { left: -260px; }
            #sidebar.active { left: 0; }
            .content-wrapper { margin-left: 0 !important; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand navbar-midnight-premium sticky-top px-4 shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-toggle-midnight rounded-3 p-2 d-flex align-items-center justify-content-center" id="menu-toggle">
                <i class="fa-solid fa-bars-staggered text-info fs-5"></i>
            </button>
            <div class="d-none d-md-block">
                <span class="badge bg-white bg-opacity-10 text-info border border-info border-opacity-20 px-3 py-2 rounded-pill font-monospace" style="font-size: 11px;">
                    <i class="fa-solid fa-server me-1 animation-pulse"></i> Server: Active
                </span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            
            <div class="text-end d-none d-sm-block me-2">
                <small class="text-white-50 d-block font-monospace" style="font-size: 10px; letter-spacing: 0.5px;">WAKTU SISTEM</small>
                <span class="fw-bold text-white small d-flex align-items-center gap-1.5" id="headerClock">
                    <i class="fa-regular fa-clock text-info"></i> 00:00 WIB
                </span>
            </div>

            <div class="vr bg-white opacity-20 d-none d-sm-block" style="height: 28px;"></div>

            <div class="d-flex align-items-center gap-2.5">
                <div class="text-end d-none d-sm-block">
                    <h6 class="fw-bold text-white mb-0" style="font-size: 13px; letter-spacing: 0.3px;">Miftahul Ulum</h6>
                    <small class="text-info opacity-75 fw-medium" style="font-size: 11px;">Sistem Manajer</small>
                </div>
                <div class="header-avatar-midnight">
                    <img src="https://ui-avatars.com/api/?name=Miftahul+Ulum&background=38bdf8&color=1e293b&size=40" 
                         alt="User Avatar" 
                         class="rounded-circle border border-2 border-info border-opacity-50 shadow-sm"
                         style="width: 38px; height: 38px; object-fit: cover;">
                </div>
            </div>

        </div>
    </div>
</nav>

<style>
/* Kontainer Utama Header - Berwarna senada dengan sidebar namun sedikit lebih terang */
.navbar-midnight-premium {
    background-color: #222d4a !important; /* Biru Midnight (satu tingkat di atas warna sidebar) */
    border-bottom: 1px solid rgba(255, 255, 255, 0.06); /* Garis pembatas tipis bercahaya */
    height: 70px;
    transition: all 0.3s ease;
}

/* Tombol Toggle Menu */
.btn-toggle-midnight {
    background-color: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    width: 38px;
    height: 38px;
    transition: all 0.2s ease;
}
.btn-toggle-midnight:hover {
    background-color: rgba(56, 189, 248, 0.1); /* Hover warna cyan transparan */
    border-color: rgba(56, 189, 248, 0.3);
    transform: scale(1.05);
}
.btn-toggle-midnight i {
    transition: color 0.2s ease;
}
.btn-toggle-midnight:hover i {
    color: #38bdf8 !important; /* Ikon ikut menyala terang */
}

/* Kustomisasi Teks Cyan Khusus */
.text-info {
    color: #38bdf8 !important; /* Menggunakan warna cyan neon lembut agar terbaca jelas */
}

/* Efek Hover Foto Profil */
.header-avatar-midnight img {
    transition: all 0.2s ease;
    cursor: pointer;
}
.header-avatar-midnight:hover img {
    transform: translateY(-1px);
    border-color: #38bdf8 !important; /* Lingkaran menyala cyan saat didekati */
    box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
}
</style>

<script>
    function updateHeaderClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const el = document.getElementById('headerClock');
        if(el) {
            el.innerHTML = `<i class="fa-regular fa-clock text-info me-1"></i> ${hours}:${minutes} WIB`;
        }
    }
    setInterval(updateHeaderClock, 1000);
    document.addEventListener("DOMContentLoaded", updateHeaderClock);
</script>
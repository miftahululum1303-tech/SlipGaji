<?php
// ==========================================
// LOGIKA PROSES INSERT DATA KARYAWAN
// ==========================================
if (isset($_POST['simpan_karyawan'])) {
    $nik  = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    
    // Query Insert (Hanya mencakup NIK dan Nama sesuai struktur minimalis)
    $insert = mysqli_query($koneksi, "INSERT INTO karyawan (nik, nama) VALUES ('$nik', '$nama')");
    
    if ($insert) {
        echo "<script>alert('Data Karyawan Berhasil Ditambahkan!'); window.location='index.php?page=karyawan';</script>";
    } else {
        echo "<script>alert('Gagal Menambahkan Data! Periksa kembali apakah NIK sudah pernah terdaftar.');</script>";
    }
}

// ==========================================
// LOGIKA PROSES HAPUS DATA KARYAWAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = intval($_GET['id']);
    
    $hapus = mysqli_query($koneksi, "DELETE FROM karyawan WHERE id_karyawan='$id_hapus'");
    if ($hapus) {
        echo "<script>alert('Data Karyawan Berhasil Dihapus!'); window.location='index.php?page=karyawan';</script>";
    }
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">
    
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-users text-primary me-2"></i>Master Manajemen Karyawan
            </h5>
            <p class="text-muted small m-0 mt-1">Kelola dan pantau seluruh data identitas nomor induk dan nama karyawan Miftahul Ulum.</p>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormKaryawan" 
                    aria-expanded="false" aria-controls="collapseFormKaryawan">
                <i class="fa-solid fa-user-plus"></i> Tambah Karyawan Baru
            </button>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 d-none d-sm-inline-block align-self-center">
                Miftahul Ulum Database
            </span>
        </div>
    </div>

    <div class="card-body">
        
        <div class="collapse mb-4" id="collapseFormKaryawan">
            <div class="p-4 bg-light rounded-3 border">
                <div class="d-flex align-items-center mb-3 text-primary">
                    <i class="fa-solid fa-address-card me-2"></i>
                    <h6 class="fw-bold m-0" style="font-size: 14px;">Isi Formulir Identitas Karyawan</h6>
                </div>
                
                <form method="POST" action="">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Nomor Induk Karyawan (NIK)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-solid fa-id-badge small"></i></span>
                                <input type="text" name="nik" class="form-control border-start-0" placeholder="Contoh: KRY202601" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap Karyawan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-solid fa-font small"></i></span>
                                <input type="text" name="nama" class="form-control border-start-0" placeholder="Masukkan nama lengkap karyawan" required>
                            </div>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button type="submit" name="simpan_karyawan" class="btn btn-success fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="myTable" class="table table-hover table-striped align-middle w-100 m-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th width="8%" class="ps-3">No</th>
                        <th width="35%">Nomor Induk Karyawan (NIK)</th>
                        <th>Nama Lengkap Karyawan</th>
                        <th width="12%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($koneksi, "SELECT id_karyawan, nik, nama FROM karyawan ORDER BY id_karyawan DESC");
                    
                    if (mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='4' class='text-center text-muted py-4 fw-medium bg-light'><i class='fa-solid fa-user-slash me-2 text-secondary'></i>Belum ada data karyawan terdaftar. Klik tombol di atas untuk menambahkan.</td></tr>";
                    }

                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td class="ps-3"><?= $no++; ?></td>
                            <td class="fw-bold text-secondary">
                                <code><?= $row['nik']; ?></code>
                            </td>
                            <td class="fw-bold text-dark" style="font-size: 14.5px;">
                                <?= $row['nama']; ?>
                            </td>
                            <td class="text-center pe-3">
                                <a href="index.php?page=karyawan&action=hapus&id=<?= $row['id_karyawan']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data karyawan <?= $row['nama']; ?>?');" 
                                   class="btn btn-white btn-sm text-danger border shadow-sm px-2.5" 
                                   title="Hapus Data">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
    .input-group:focus-within .input-group-text {
        border-color: #3e7ccb;
        color: #3e7ccb !important;
    }
    .table th {
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .btn-white {
        background-color: #fff;
        color: #dc3545;
    }
    .btn-white:hover {
        background-color: #dc3545;
        color: #fff;
    }
    code {
        font-size: 14px;
        color: #6c757d;
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
</style>
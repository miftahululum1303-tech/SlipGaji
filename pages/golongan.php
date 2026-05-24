<?php
// ==========================================
// LOGIKA PROSES INSERT DATA GOLONGAN
// ==========================================
if (isset($_POST['simpan_golongan'])) {
    $nama_golongan = mysqli_real_escape_string($koneksi, $_POST['nama_golongan']);
    
    // Eksekusi Query Insert Murni
    $insert = mysqli_query($koneksi, "INSERT INTO golongan (nama_golongan) VALUES ('$nama_golongan')");
    
    if ($insert) {
        echo "<script>alert('Data Golongan Berhasil Ditambahkan!'); window.location='index.php?page=golongan';</script>";
    } else {
        echo "<script>alert('Gagal Menambahkan Data! Periksa kembali inputan Anda.');</script>";
    }
}

// ==========================================
// LOGIKA PROSES HAPUS DATA GOLONGAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = intval($_GET['id']);
    
    $hapus = mysqli_query($koneksi, "DELETE FROM golongan WHERE id_golongan='$id_hapus'");
    if ($hapus) {
        echo "<script>alert('Data Golongan Berhasil Dihapus!'); window.location='index.php?page=golongan';</script>";
    }
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">
    
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-layer-group text-primary me-2"></i>Master Manajemen Golongan
            </h5>
            <p class="text-muted small m-0 mt-1">Kelola daftar standarisasi golongan pangkat karyawan.</p>
        </div>
        
        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" 
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFormGolongan" 
                    aria-expanded="false" aria-controls="collapseFormGolongan">
                <i class="fa-solid fa-circle-plus"></i> Tambah Golongan Baru
            </button>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 d-none d-sm-inline-block align-self-center">
                Database Perusahaan
            </span>
        </div>
    </div>

    <div class="card-body">
        
        <div class="collapse mb-4" id="collapseFormGolongan">
            <div class="p-4 bg-light rounded-3 border">
                <div class="d-flex align-items-center mb-3 text-primary">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    <h6 class="fw-bold m-0" style="font-size: 14px;">Isi Formulir Golongan Baru</h6>
                </div>
                
                <form method="POST" action="">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-9">
                            <label class="form-label small fw-bold text-secondary">Nama Golongan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-solid fa-tags small"></i></span>
                                <input type="text" name="nama_golongan" class="form-control border-start-0" placeholder="Contoh: Golongan I / Golongan II / Eksekutif" required>
                            </div>
                        </div>

                        <div class="col-md-3 d-grid">
                            <button type="submit" name="simpan_golongan" class="btn btn-success fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Golongan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelGolongan" class="table table-hover table-striped align-middle w-100 m-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th width="10%" class="ps-3">No</th>
                        <th>Nama Golongan</th>
                        <th width="15%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // KOREKSI TOTAL: memanggil tabel murni tanpa awalan database apapun
                    $sql = mysqli_query($koneksi, "SELECT * FROM golongan ORDER BY id_golongan DESC");
                    
                    if ($sql && mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='3' class='text-center text-muted py-4 fw-medium bg-light'><i class='fa-solid fa-folder-open me-2 text-secondary'></i>Belum ada data golongan terdaftar. Klik tombol di atas untuk menambah.</td></tr>";
                    }

                    while ($sql && $row = mysqli_fetch_array($sql)) {
                    ?>
                        <tr>
                            <td class="ps-3"><?= $no++; ?></td>
                            <td class="fw-bold text-dark">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded fs-6">
                                    <?= $row['nama_golongan']; ?>
                                </span>
                            </td>
                            <td class="text-center pe-3">
                                <a href="index.php?page=golongan&action=hapus&id=<?= $row['id_golongan']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $row['nama_golongan']; ?>?');" 
                                   class="btn btn-white btn-sm text-danger border shadow-sm px-2.5" 
                                   title="Hapus Data">
                                    <i class="fa-solid fa-trash-can"></i> Hapus
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
        border-color: #0d6efd;
        color: #0d6efd !important;
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
</style>
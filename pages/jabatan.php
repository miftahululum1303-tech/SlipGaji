<?php
// ==========================================
// LOGIKA PROSES INSERT DATA JABATAN
// ==========================================
if (isset($_POST['simpan_jabatan'])) {
    $gaji_pokok = mysqli_real_escape_string($koneksi, $_POST['gaji_pokok']);
    $tunjangan_jabatan = mysqli_real_escape_string($koneksi, $_POST['tunjangan_jabatan']);
    $nama_jabatan = mysqli_real_escape_string($koneksi, $_POST['nama_jabatan']);

    // Eksekusi Query Insert Murni ke tabel jabatan
    $insert = mysqli_query($koneksi, "INSERT INTO jabatan (nama_jabatan, gaji_pokok, tunjangan_jabatan) VALUES ('$nama_jabatan', '$gaji_pokok', '$tunjangan_jabatan')");

    if ($insert) {
        echo "<script>alert('Data Jabatan Berhasil Ditambahkan!'); window.location='index.php?page=jabatan';</script>";
    } else {
        echo "<script>alert('Gagal Menambahkan Data! Periksa kembali inputan Anda.');</script>";
    }
}

// ==========================================
// LOGIKA PROSES HAPUS DATA JABATAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = intval($_GET['id']);

    $hapus = mysqli_query($koneksi, "DELETE FROM jabatan WHERE id_jabatan='$id_hapus'");
    if ($hapus) {
        echo "<script>alert('Data Jabatan Berhasil Dihapus!'); window.location='index.php?page=jabatan';</script>";
    }
}

// ==========================================
// LOGIKA UPDATE DATA JABATAN
// ==========================================
if (isset($_POST['update_jabatan'])) {
    $id_jabatan = intval($_POST['id_jabatan']);
    $nama_jabatan = mysqli_real_escape_string($koneksi, $_POST['nama_jabatan']);
    $gaji_pokok = mysqli_real_escape_string($koneksi, $_POST['gaji_pokok']);
    $tunjangan_jabatan = mysqli_real_escape_string($koneksi, $_POST['tunjangan_jabatan']);

    mysqli_query(
        $koneksi,
        "UPDATE jabatan
         SET
            nama_jabatan='$nama_jabatan',
            gaji_pokok='$gaji_pokok',
            tunjangan_jabatan='$tunjangan_jabatan'
         WHERE id_jabatan='$id_jabatan'",
    );

    echo "<script>
        alert('Data Jabatan Berhasil Diupdate!');
        window.location='index.php?page=jabatan';
    </script>";
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">

    <div
        class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-briefcase text-primary me-2"></i>Master Manajemen Jabatan
            </h5>
            <p class="text-muted small m-0 mt-1">Kelola daftar standarisasi posisi penugasan jabatan karyawan.</p>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseFormJabatan" aria-expanded="false"
                aria-controls="collapseFormJabatan">
                <i class="fa-solid fa-circle-plus"></i> Tambah Jabatan Baru
            </button>
            <span
                class="badge bg-light text-dark border rounded-pill px-3 py-2 d-none d-sm-inline-block align-self-center">
                Miftahul Ulum Database
            </span>
        </div>
    </div>

    <div class="card-body">

        <div class="collapse mb-4" id="collapseFormJabatan">
            <div class="p-4 bg-light rounded-3 border">
                <div class="d-flex align-items-center mb-3 text-primary">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    <h6 class="fw-bold m-0" style="font-size: 14px;">Isi Formulir Jabatan Baru</h6>
                </div>

                <form method="POST" action="">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary">Nama Jabatan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i
                                        class="fa-solid fa-user-tie small"></i></span>
                                <input type="text" name="nama_jabatan" class="form-control border-start-0"
                                    placeholder="Contoh: Direktur Utama / Manajer Keuangan / Staff Administrasi"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary">
                                Gaji Pokok
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0">
                                    Rp
                                </span>
                                <input type="number" name="gaji_pokok" class="form-control border-start-0"
                                    placeholder="5000000" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary">
                                Tunjangan Jabatan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0">
                                    Rp
                                </span>
                                <input type="number" name="tunjangan_jabatan" class="form-control border-start-0"
                                    placeholder="1000000" required>
                            </div>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button type="submit" name="simpan_jabatan" class="btn btn-success fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Jabatan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelJabatan" class="table table-hover table-striped align-middle w-100 m-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th width="10%" class="ps-3">No</th>
                        <th>Nama Jabatan</th>
                        <th width="20%">Gaji Pokok</th>
                        <th width="20%">Tunjangan</th>
                        <th width="15%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Memanggil tabel murni tanpa awalan database sandbox
                    $sql = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY id_jabatan DESC");

                    if ($sql && mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='5' class='text-center text-muted py-4 fw-medium bg-light'><i class='fa-solid fa-folder-open me-2 text-secondary'></i>Belum ada data jabatan terdaftar. Klik tombol di atas untuk menambah.</td></tr>";
                    }

                    while ($sql && $row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td class="ps-3"><?= $no++ ?></td>
                        <td class="fw-bold text-dark">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded fs-6 text-dark">
                                <?= $row['nama_jabatan'] ?>
                            </span>
                        </td>
                        <td class="fw-bold text-success">
                            Rp <?= number_format($row['gaji_pokok'], 0, ',', '.') ?>
                        </td>
                        <td class="fw-bold text-primary">
                            Rp <?= number_format($row['tunjangan_jabatan'], 0, ',', '.') ?>
                        </td>
                        <td class="text-center pe-3">
                            <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#edit<?= $row['id_jabatan'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <a href="index.php?page=jabatan&action=hapus&id=<?= $row['id_jabatan'] ?>"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data jabatan <?= $row['nama_jabatan'] ?>?');"
                                class="btn btn-white btn-sm text-danger border shadow-sm px-2.5" title="Hapus Data">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="edit<?= $row['id_jabatan'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            Edit Data Jabatan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_jabatan" value="<?= $row['id_jabatan'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Nama Jabatan
                                            </label>
                                            <input type="text" name="nama_jabatan" class="form-control"
                                                value="<?= $row['nama_jabatan'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Gaji Pokok
                                            </label>
                                            <input type="number" name="gaji_pokok" class="form-control"
                                                value="<?= $row['gaji_pokok'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Tunjangan Jabatan
                                            </label>
                                            <input type="number" name="tunjangan_jabatan" class="form-control"
                                                value="<?= $row['tunjangan_jabatan'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update_jabatan" class="btn btn-primary">
                                            Update Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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

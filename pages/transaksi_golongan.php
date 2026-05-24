<?php
// ==========================================
// LOGIKA PROSES INSERT TRANSAKSI GOLONGAN
// ==========================================
if (isset($_POST['simpan_transaksi'])) {
    $id_karyawan = intval($_POST['id_karyawan']);
    $id_golongan = intval($_POST['id_golongan']);

    // Cek apakah NIK ini sudah pernah diatur golongannya agar tidak ganda
    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi_golongan WHERE id_karyawan = '$id_karyawan'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Error: Karyawan dengan NIK tersebut sudah memiliki golongan!'); window.location='index.php?page=transaksi_golongan';</script>";
    } else {
        // Jalankan query insert murni tanpa embel-embel nama database sandbox
        $insert = mysqli_query($koneksi, "INSERT INTO transaksi_golongan (id_karyawan, id_golongan, tanggal_mulai) VALUES ('$id_karyawan', '$id_golongan', NOW())");

        if ($insert) {
            echo "<script>alert('Transaksi Golongan Berhasil Disimpan!'); window.location='index.php?page=transaksi_golongan';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan transaksi! Periksa kembali koneksi database.');</script>";
        }
    }
}

// ==========================================
// LOGIKA PROSES HAPUS TRANSAKSI GOLONGAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = intval($_GET['id']);

    $hapus = mysqli_query($koneksi, "DELETE FROM transaksi_golongan WHERE id_transaksi_golongan='$id_hapus'");
    if ($hapus) {
        echo "<script>alert('Data Transaksi Berhasil Dihapus!'); window.location='index.php?page=transaksi_golongan';</script>";
    }
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">

    <div
        class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-money-bill-transfer text-primary me-2"></i>Transaksi Golongan Karyawan
            </h5>
            <p class="text-muted small m-0 mt-1">Hubungkan Nomor Induk Karyawan dengan standarisasi golongan yang
                berlaku.</p>
        </div>

        <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" type="button"
            data-bs-toggle="collapse" data-bs-target="#collapseFormTransaksi" aria-expanded="false"
            aria-controls="collapseFormTransaksi">
            <i class="fa-solid fa-circle-plus"></i> Input Transaksi Baru
        </button>
    </div>

    <div class="card-body">

        <div class="collapse mb-4" id="collapseFormTransaksi">
            <div class="p-4 bg-light rounded-3 border">
                <div class="d-flex align-items-center mb-3 text-primary">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    <h6 class="fw-bold m-0" style="font-size: 14px;">Formulir Pemetaan Golongan</h6>
                </div>

                <form method="POST" action="">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Pilih Karyawan (NIK)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i
                                        class="fa-solid fa-id-card small"></i></span>
                                <select name="id_karyawan" class="form-select border-start-0" required>
                                    <option value="">-- Pilih NIK / Karyawan --</option>
                                    <?php
                                    // Ambil data dari tabel karyawan (sesuaikan nama tabel Anda jika berbeda, misal 'user' atau 'karyawan')
                                    $q_kry = mysqli_query($koneksi, 'SELECT id_karyawan, nik, nama_karyawan FROM karyawan ORDER BY nik ASC');

                                    while ($k = mysqli_fetch_array($q_kry)) {
                                        echo "<option value='" . $k['id_karyawan'] . "'>" . $k['nik'] . ' - ' . $k['nama_karyawan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Pilih Golongan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i
                                        class="fa-solid fa-layer-group small"></i></span>
                                <select name="id_golongan" class="form-select border-start-0" required>
                                    <option value="">-- Pilih Golongan Pangkat --</option>
                                    <?php
                                    $q_gol = mysqli_query($koneksi, 'SELECT * FROM golongan ORDER BY nama_golongan ASC');
                                    while ($g = mysqli_fetch_array($q_gol)) {
                                        echo "<option value='" . $g['id_golongan'] . "'>" . $g['nama_golongan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button type="submit" name="simpan_transaksi" class="btn btn-success fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelTransaksiGolongan" class="table table-hover table-striped align-middle w-100 m-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th width="10%" class="ps-3">No</th>
                        <th width="35%">Nomor Induk Karyawan (NIK)</th>
                        <th>Golongan</th>
                        <th width="15%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Query INNER JOIN untuk menggabungkan data transaksi dengan nama golongan asli
                    $sql = mysqli_query($koneksi, "SELECT tg.*, k.nik, k.nama_karyawan, g.nama_golongan FROM transaksi_golongan tg INNER JOIN karyawan k ON tg.id_karyawan = k.id_karyawan INNER JOIN golongan g ON tg.id_golongan = g.id_golongan ORDER BY tg.id_transaksi_golongan DESC");

                    if ($sql && mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='4' class='text-center text-muted py-4 fw-medium bg-light'><i class='fa-solid fa-folder-open me-2 text-secondary'></i>Belum ada transaksi golongan terdata.</td></tr>";
                    }

                    while ($sql && $row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td class="ps-3"><?= $no++ ?></td>
                        <td class="fw-semibold text-secondary"><i
                                class="fa-solid fa-user small me-2 text-muted"></i><?= $row['nik']; ?> - <?= $row['nama_karyawan']; ?></td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded fs-6">
                                <?= $row['nama_golongan'] ?>
                            </span>
                        </td>
                        <td class="text-center pe-3">
                            <a href="index.php?page=transaksi_golongan&action=hapus&id=<?= $row['id_transaksi_golongan'] ?>"
                                onclick="return confirm('Hapus pemetaan golongan untuk NIK <?= $row['nik']; ?> - <?= $row['nama_karyawan']; ?>?');"
                                class="btn btn-white btn-sm text-danger border shadow-sm px-2.5">
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

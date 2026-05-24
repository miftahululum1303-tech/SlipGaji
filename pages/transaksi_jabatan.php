<?php
// ==========================================
// LOGIKA PROSES INSERT TRANSAKSI JABATAN
// ==========================================
if (isset($_POST['simpan_transaksi_jabatan'])) {
    $id_karyawan = intval($_POST['id_karyawan']);
    $id_jabatan = intval($_POST['id_jabatan']);

    // Cek apakah NIK ini sudah pernah diatur jabatannya agar tidak ganda
    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi_jabatan WHERE id_karyawan = '$id_karyawan'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Error: Karyawan dengan NIK tersebut sudah memiliki jabatan!'); window.location='index.php?page=transaksi_jabatan';</script>";
    } else {
        // Jalankan query insert murni murni ke tabel transaksi_jabatan
        $insert = mysqli_query($koneksi, "INSERT INTO transaksi_jabatan (id_karyawan, id_jabatan, tanggal_mulai) VALUES ('$id_karyawan','$id_jabatan', NOW())");

        if ($insert) {
            echo "<script>alert('Transaksi Jabatan Berhasil Disimpan!'); window.location='index.php?page=transaksi_jabatan';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan transaksi! Periksa kembali koneksi database.');</script>";
        }
    }
}

// ==========================================
// LOGIKA PROSES HAPUS TRANSAKSI JABATAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_hapus = intval($_GET['id']);

    $hapus = mysqli_query($koneksi, "DELETE FROM transaksi_jabatan WHERE id_transaksi_jabatan='$id_hapus'");
    if ($hapus) {
        echo "<script>alert('Data Transaksi Jabatan Berhasil Dihapus!'); window.location='index.php?page=transaksi_jabatan';</script>";
    }
}

// ==========================================
// LOGIKA UPDATE TRANSAKSI JABATAN
// ==========================================
if (isset($_POST['update_transaksi_jabatan'])) {
    $id_transaksi = intval($_POST['id_transaksi_jabatan']);

    $id_karyawan = intval($_POST['id_karyawan']);

    $id_jabatan = intval($_POST['id_jabatan']);

    mysqli_query(
        $koneksi,
        "UPDATE transaksi_jabatan
         SET
            id_karyawan='$id_karyawan',
            id_jabatan='$id_jabatan'
         WHERE id_transaksi_jabatan='$id_transaksi'",
    );

    echo "<script>
        alert('Transaksi Jabatan Berhasil Diupdate!');
        window.location='index.php?page=transaksi_jabatan';
    </script>";
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">

    <div
        class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-address-book text-primary me-2"></i>Transaksi Jabatan Karyawan
            </h5>
            <p class="text-muted small m-0 mt-1">Petakan penugasan posisi jabatan struktural maupun fungsional karyawan.
            </p>
        </div>

        <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" type="button"
            data-bs-toggle="collapse" data-bs-target="#collapseFormTransaksiJabatan" aria-expanded="false"
            aria-controls="collapseFormTransaksiJabatan">
            <i class="fa-solid fa-circle-plus"></i> Input Jabatan Baru
        </button>
    </div>

    <div class="card-body">

        <div class="collapse mb-4" id="collapseFormTransaksiJabatan">
            <div class="p-4 bg-light rounded-3 border">
                <div class="d-flex align-items-center mb-3 text-primary">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    <h6 class="fw-bold m-0" style="font-size: 14px;">Formulir Pemetaan Penugasan Jabatan</h6>
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
                                    // Mengambil data dari tabel karyawan
                                    $q_kry = mysqli_query($koneksi, 'SELECT id_karyawan, nik, nama_karyawan FROM karyawan ORDER BY nik ASC');

                                    if (!$q_kry) {
                                        $q_kry = mysqli_query($koneksi, 'SELECT nik, nama FROM user ORDER BY nik ASC');
                                    }
                                    while ($k = mysqli_fetch_array($q_kry)) {
                                        echo "<option value='" . $k['id_karyawan'] . "'>" . $k['nik'] . ' - ' . $k['nama_karyawan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary">Pilih Jabatan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i
                                        class="fa-solid fa-user-tie small"></i></span>
                                <select name="id_jabatan" class="form-select border-start-0" required>
                                    <option value="">-- Pilih Posisi Jabatan --</option>
                                    <?php
                                    $q_jab = mysqli_query($koneksi, 'SELECT * FROM jabatan ORDER BY nama_jabatan ASC');
                                    while ($j = mysqli_fetch_array($q_jab)) {
                                        echo "<option value='" . $j['id_jabatan'] . "'>" . $j['nama_jabatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button type="submit" name="simpan_transaksi_jabatan"
                                class="btn btn-success fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelTransaksiJabatan" class="table table-hover table-striped align-middle w-100 m-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th width="10%" class="ps-3">No</th>
                        <th width="35%">Nomor Induk Karyawan (NIK)</th>
                        <th>Jabatan</th>
                        <th width="15%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Query INNER JOIN murni untuk menggabungkan data transaksi dengan nama jabatan asli
                    $sql = mysqli_query($koneksi, "SELECT tj.*, k.nik, k.nama_karyawan, j.nama_jabatan FROM transaksi_jabatan tj INNER JOIN karyawan k ON tj.id_karyawan = k.id_karyawan INNER JOIN jabatan j ON tj.id_jabatan = j.id_jabatan ORDER BY tj.id_transaksi_jabatan DESC");

                    if ($sql && mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='4' class='text-center text-muted py-4 fw-medium bg-light'><i class='fa-solid fa-folder-open me-2 text-secondary'></i>Belum ada transaksi jabatan terdata.</td></tr>";
                    }

                    while ($sql && $row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td class="ps-3"><?= $no++ ?></td>
                        <td class="fw-semibold text-secondary"><i
                                class="fa-solid fa-user small me-2 text-muted"></i><?= $row['nik'] ?> -
                            <?= $row['nama_karyawan'] ?></td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded fs-6 text-dark">
                                <?= $row['nama_jabatan'] ?>
                            </span>
                        </td>
                        <td class="text-center pe-3">
                            <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#edit<?= $row['id_transaksi_jabatan'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <a href="index.php?page=transaksi_jabatan&action=hapus&id=<?= $row['id_transaksi_jabatan'] ?>"
                                onclick="return confirm('Hapus pemetaan jabatan untuk NIK <?= $row['nik'] ?> - <?= $row['nama_karyawan'] ?>?');"
                                class="btn btn-white btn-sm text-danger border shadow-sm px-2.5">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="edit<?= $row['id_transaksi_jabatan'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            Edit Transaksi Jabatan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_transaksi_jabatan"
                                            value="<?= $row['id_transaksi_jabatan'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Karyawan
                                            </label>
                                            <select name="id_karyawan" class="form-select" required>
                                                <?php $edit_karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama_karyawan ASC");

                                                while ($ek = mysqli_fetch_array($edit_karyawan)) {?>

                                                <option value="<?= $ek['id_karyawan'] ?>"
                                                    <?= $ek['id_karyawan'] == $row['id_karyawan'] ? 'selected' : '' ?>>
                                                    <?= $ek['nik'] ?> - <?= $ek['nama_karyawan'] ?>
                                                </option>

                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Jabatan
                                            </label>
                                            <select name="id_jabatan" class="form-select" required>
                                                <?php $edit_jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY nama_jabatan ASC");

                                                while ($ej = mysqli_fetch_array($edit_jabatan)) { ?>

                                                <option value="<?= $ej['id_jabatan'] ?>"
                                                    <?= $ej['id_jabatan'] == $row['id_jabatan'] ? 'selected' : '' ?>>
                                                    <?= $ej['nama_jabatan'] ?>
                                                </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update_transaksi_jabatan" class="btn btn-primary">
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

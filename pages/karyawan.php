<?php
// ==========================================
// LOGIKA PROSES INSERT DATA KARYAWAN
// ==========================================
if (isset($_POST['simpan_karyawan'])) {
    // Ambil ID terakhir
    $query_last = mysqli_query(
        $koneksi,
        "SELECT id_karyawan FROM karyawan
     ORDER BY id_karyawan DESC LIMIT 1",
    );

    $data_last = mysqli_fetch_assoc($query_last);

    $last_id = $data_last ? $data_last['id_karyawan'] + 1 : 1;

    // Generate NIK otomatis
    $nik = 'KRY' . str_pad($last_id, 3, '0', STR_PAD_LEFT);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

    // Query Insert (Hanya mencakup NIK dan Nama sesuai struktur minimalis)
    $insert = mysqli_query(
        $koneksi,
        "INSERT INTO karyawan (nik, nama_karyawan)
     VALUES ('$nik', '$nama')",
    );

    if ($insert) {
        if ($insert) {
            $id_karyawan = mysqli_insert_id($koneksi);

            $username = $nik;
            $password = MD5('123456');

            mysqli_query(
                $koneksi,
                "INSERT INTO users (
            id_karyawan,
            username,
            password,
            role
        ) VALUES (
            '$id_karyawan',
            '$username',
            '$password',
            'karyawan'
        )",
            );

            echo "<script>
        alert('Data Karyawan Berhasil Ditambahkan!');
        window.location='index.php?page=karyawan';
    </script>";
        }
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

// ==========================================
// LOGIKA PROSES RESET PASSWORD KARYAWAN
// ==========================================
if (isset($_GET['action']) && $_GET['action'] == 'reset') {
    $id_reset = intval($_GET['id']);
    $password_baru = MD5('123456');

    mysqli_query(
        $koneksi,
        "UPDATE users
         SET password='$password_baru'
         WHERE id_karyawan='$id_reset'",
    );

    echo "<script>
        alert('Password berhasil direset menjadi 123456');
        window.location='index.php?page=karyawan';
    </script>";
}
?>

<div class="card border-0 shadow-sm bg-white rounded-3">

    <div
        class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="fa-solid fa-users text-primary me-2"></i>
                Master Manajemen Karyawan
            </h5>
            <p class="text-muted small m-0 mt-1">
                Kelola dan pantau seluruh data identitas nomor induk dan nama karyawan Miftahul Ulum.
            </p>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold btn-sm px-3 shadow-sm d-flex align-items-center gap-2" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseFormKaryawan" aria-expanded="false"
                aria-controls="collapseFormKaryawan">
                <i class="fa-solid fa-user-plus"></i>
                Tambah Karyawan Baru
            </button>
            <span
                class="badge bg-light text-dark border rounded-pill px-3 py-2 d-none d-sm-inline-block align-self-center">
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
                        <div class="col-md-10">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap Karyawan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i
                                        class="fa-solid fa-font small"></i></span>
                                <input type="text" name="nama" class="form-control border-start-0"
                                    placeholder="Masukkan nama lengkap karyawan" required>
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
                        <th width="20%">NIK</th>
                        <th>Nama Karyawan</th>
                        <th width="20%">Username Login</th>
                        <th width="18%" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($koneksi, "SELECT karyawan.id_karyawan, karyawan.nik, karyawan.nama_karyawan, users.username FROM karyawan LEFT JOIN users ON users.id_karyawan = karyawan.id_karyawan ORDER BY karyawan.id_karyawan DESC");

                    if (mysqli_num_rows($sql) == 0) {
                        ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4 fw-medium bg-light">
                            <i class="fa-solid fa-user-slash me-2 text-secondary"></i>
                            Belum ada data karyawan terdaftar.
                        </td>
                    </tr>
                    <?php
                    } else {
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <div class="modal fade" id="akun<?= $row['id_karyawan'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">
                                            Informasi Akun Karyawan
                                        </h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="small text-muted">Nama Karyawan</label>
                                            <div class="fw-bold">
                                                <?= $row['nama_karyawan'] ?>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="small text-muted">Username</label>
                                            <div>
                                                <code><?= $row['username'] ?></code>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="small text-muted">Password Default</label>
                                            <div>
                                                <code>123456</code>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <td class="ps-3"><?= $no++ ?></td>

                        <td class="fw-bold text-secondary">
                            <code><?= $row['nik'] ?></code>
                        </td>

                        <td class="fw-bold text-dark">
                            <?= $row['nama_karyawan'] ?>
                        </td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <?= $row['username'] ?>
                            </span>
                        </td>

                        <td class="text-center pe-3">

                            <!-- LIHAT AKUN -->
                            <button class="btn btn-info btn-sm text-white shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#akun<?= $row['id_karyawan'] ?>">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <!-- RESET PASSWORD -->
                            <a href="index.php?page=karyawan&action=reset&id=<?= $row['id_karyawan'] ?>"
                                onclick="return confirm('Reset password menjadi 123456 ?')"
                                class="btn btn-warning btn-sm text-white shadow-sm">
                                <i class="fa-solid fa-rotate"></i>
                            </a>

                            <!-- HAPUS -->
                            <a href="index.php?page=karyawan&action=hapus&id=<?= $row['id_karyawan'] ?>"
                                onclick="return confirm('Hapus data <?= $row['nama_karyawan'] ?> ?');"
                                class="btn btn-danger btn-sm shadow-sm">
                                <i class="fa-solid fa-trash"></i>
                            </a>

                        </td>
                    </tr>
                    <?php } ?>
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

<?php
// ==========================================
// LOGIKA PROSES UPDATE PROFIL & FOTO REAL
// ==========================================
if (isset($_POST['simpan_profil'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Simulasikan ID user yang sedang login (Sesuaikan dengan session login aplikasi Anda jika ada)
    $id_user_login = $_SESSION['id_user'];

    // Ambil data file foto yang diunggah
    $nama_foto = $_FILES['foto_profil']['name'];
    $ukuran_foto = $_FILES['foto_profil']['size'];
    $error_foto = $_FILES['foto_profil']['error'];
    $tmp_foto = $_FILES['foto_profil']['tmp_name'];

    // Jika user mengunggah foto baru
    if ($error_foto === 0) {
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_file = explode('.', $nama_foto);
        $ekstensi_file = strtolower(end($ekstensi_file));

        // Validasi Ekstensi Berkas
        if (!in_array($ekstensi_file, $ekstensi_valid)) {
            echo "<script>alert('Format file tidak valid! Harap pilih gambar JPG atau PNG.'); window.location='index.php?page=profil';</script>";
            exit();
        }

        // Validasi Ukuran (Maksimal 2MB = 2097152 bytes)
        if ($ukuran_foto > 2097152) {
            echo "<script>alert('Ukuran foto terlalu besar! Maksimal adalah 2 MB.'); window.location='index.php?page=profil';</script>";
            exit();
        }

        // Generate nama file baru agar unik dan tidak tabrakan di folder
        $nama_foto_baru = 'avatar_' . time() . '.' . $ekstensi_file;
        $jalur_simpan = 'assets/uploads/' . $nama_foto_baru;

        // Pindahkan file dari penyimpanan sementara ke folder tujuan proyek
        if (move_uploaded_file($tmp_foto, $jalur_simpan)) {
            $query_update = "UPDATE users SET nama='$nama', email='$email', foto='$nama_foto_baru' WHERE id_user='$id_user_login'";
            $eksekusi = mysqli_query($koneksi, $query_update);

            if ($eksekusi) {
                echo "<script>alert('Profil dan Foto Baru Berhasil Diperbarui!'); window.location='index.php?page=profil';</script>";
                exit();
            } else {
                echo "<script>alert('Gagal memperbarui database! Periksa nama tabel/kolom Anda.'); window.location='index.php?page=profil';</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah gambar ke server folder! Periksa hak akses folder assets/uploads/.'); window.location='index.php?page=profil';</script>";
        }
    } else {
        // Jika user HANYA mengganti nama/email tanpa mengubah foto profil
        $query_update = "UPDATE users SET nama='$nama', email='$email' WHERE id_user='$id_user_login'";
        $eksekusi = mysqli_query($koneksi, $query_update);

        if ($eksekusi) {
            echo "<script>alert('Data Profil Berhasil Diperbarui!'); window.location='index.php?page=profil';</script>";
            exit();
        }
    }
}

// ==========================================
// AMBIL DATA PROFIL AKTIF DARI DATABASE
// ==========================================
$id_aktif = $_SESSION['id_user'];
$ambil_data = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$id_aktif'");
$data_user = mysqli_fetch_assoc($ambil_data);

// Set default nama dan email jika database kosong
$nama_sekarang = !empty($data_user['nama']) ? $data_user['nama'] : 'Miftahul Ulum';
$email_sekarang = !empty($data_user['email']) ? $data_user['email'] : 'miftahululum1303@gmail.com';

// Set default gambar jika di database masih kosong atau file fisik tidak ditemukan
$foto_profil_sekarang = 'https://ui-avatars.com/api/?name=' . urlencode($nama_sekarang) . '&background=0D6EFD&color=fff&size=128';
if (!empty($data_user['foto']) && file_exists('assets/uploads/' . $data_user['foto'])) {
    $foto_profil_sekarang = 'assets/uploads/' . $data_user['foto'];
}
?>

<div class="row g-4 animate-fade-in content-page-premium">

    <div class="col-lg-4">
        <div class="card card-premium text-center p-4 rounded-4 h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div class="profile-avatar-wrapper mb-3 position-relative">
                    <img src="<?= $foto_profil_sekarang ?>" alt="Avatar"
                        class="rounded-circle img-thumbnail avatar-premium-border p-2"
                        style="width: 130px; height: 130px; object-fit: cover;">
                    <span
                        class="position-absolute bottom-0 end-0 bg-info p-2 border border-3 border-card rounded-circle animation-pulse"
                        title="Online"></span>
                </div>

                <h5 class="fw-bold text-premium-dark mb-1"><?= $nama_sekarang ?></h5>
                <p class="text-premium-muted small mb-3"><?= $email_sekarang ?></p>

                <span class="badge badge-premium-role px-3 py-2 rounded-pill fw-bold small">
                    <i class="fa-solid fa-shield-halved me-1"></i> Sistem Manajer
                </span>

                <hr class="w-100 my-4 line-premium-separator">
                <p class="text-premium-muted font-monospace m-0" style="font-size: 11px;">Miftahul Ulum Payroll System
                    v1.0</p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card card-premium p-4 rounded-4">
            <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom border-light-subtle">
                <div class="p-2 bg-midnight-icon text-info rounded-3">
                    <i class="fa-solid fa-user-gear fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-premium-dark m-0">Pengaturan Profil Pengguna</h5>
                    <p class="text-premium-muted small m-0">Perbarui data personal akun operasional Anda secara berkala.
                    </p>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row g-3">

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-premium-label">Nama Lengkap</label>
                        <div class="input-group input-group-premium">
                            <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $nama_sekarang ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-premium-label">Alamat Email</label>
                        <div class="input-group input-group-premium">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="<?= $email_sekarang ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-premium-label">Jabatan Akses</label>
                        <div class="input-group input-group-premium disabled-premium">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="text" class="form-control" value="<?= ucfirst($_SESSION['role']) ?>"
                                readonly disabled>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label small fw-bold text-premium-label">Ganti Foto Profil</label>
                        <input type="file" name="foto_profil" class="form-control file-premium" accept="image/*">
                        <div class="form-text text-premium-muted" style="font-size: 11px;">Format: JPG, PNG. Maksimal
                            ukuran file 2 MB.</div>
                    </div>

                    <div class="col-md-12 d-flex justify-content-end gap-2 pt-3 border-top border-light-subtle">
                        <button type="reset" class="btn btn-premium-light btn-sm fw-bold px-4 rounded-pill">
                            <i class="fa-solid fa-rotate-left me-1"></i> Batal
                        </button>
                        <button type="submit" name="simpan_profil"
                            class="btn btn-premium-primary btn-sm fw-bold px-4 rounded-pill shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* 1. Mengubah background total di belakang kartu profil */
    body,
    main,
    .content-wrapper,
    #content {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        min-height: 100vh;
        position: relative;
    }

    /* 2. Style Kartu Utama (Cards) */
    .card-premium {
        background-color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5) !important;
    }

    /* 3. Pewarnaan Teks & Pembatas */
    .text-premium-dark {
        color: #1e293b !important;
    }

    .text-premium-muted {
        color: #64748b !important;
    }

    .text-premium-label {
        color: #475569 !important;
    }

    .line-premium-separator {
        border-color: rgba(34, 45, 74, 0.1) !important;
    }

    .border-card {
        border-color: #ffffff !important;
    }

    .bg-midnight-icon {
        background-color: #222d4a !important;
    }

    .text-info {
        color: #38bdf8 !important;
    }

    .badge-premium-role {
        background-color: rgba(34, 45, 74, 0.06) !important;
        color: #222d4a !important;
        border: 1px solid rgba(34, 45, 74, 0.1);
    }

    /* 4. Komponen Form Input */
    .input-group-premium .input-group-text {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #64748b !important;
    }

    .input-group-premium .form-control {
        border-color: #cbd5e1 !important;
        color: #334155 !important;
        background-color: #ffffff !important;
    }

    .input-group-premium:focus-within .input-group-text {
        border-color: #38bdf8 !important;
        color: #0284c7 !important;
        background-color: #ffffff !important;
    }

    .input-group-premium:focus-within .form-control {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15) !important;
    }

    .disabled-premium .input-group-text,
    .disabled-premium .form-control {
        background-color: #f1f5f9 !important;
        color: #94a3b8 !important;
    }

    .file-premium {
        border: 1px dashed #cbd5e1 !important;
        background-color: #f8fafc !important;
    }

    /* 5. Tombol Aksi */
    .btn-premium-primary {
        background: linear-gradient(135deg, #222d4a 0%, #1a233a 100%) !important;
        border: none !important;
        color: #ffffff !important;
    }

    .btn-premium-primary:hover {
        background: linear-gradient(135deg, #1a233a 0%, #0f172a 100%) !important;
        box-shadow: 0 4px 12px rgba(26, 35, 58, 0.2) !important;
    }

    .btn-premium-light {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
    }

    .avatar-premium-border {
        border-color: rgba(34, 45, 74, 0.15) !important;
    }

    /* 6. Custom Scrollbar Browser */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #0f172a;
    }

    ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }
</style>

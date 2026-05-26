<?php

include 'pages/profil/proses.php';

/* ========================================
   AMBIL DATA USER
======================================== */

$idUser = intval($_SESSION['id_user'] ?? 0);

$query = mysqli_query(
    $koneksi,

    "SELECT

        users.*,
        karyawan.*

     FROM users

     LEFT JOIN karyawan
        ON users.id_karyawan =
           karyawan.id_karyawan

     WHERE
        users.id_user='$idUser'

     LIMIT 1",
);

$data = mysqli_fetch_assoc($query);

/* ========================================
   DEFAULT DATA
======================================== */

$nama = $data['nama_karyawan'] ?? 'Karyawan';

$email = $data['email'] ?? '-';

$foto = 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=0D6EFD&color=fff';

if (!empty($data['foto']) && file_exists('assets/uploads/' . $data['foto'])) {
    $foto = 'assets/uploads/' . $data['foto'];
}

?>


<div class="row g-4">

    <!-- PROFILE CARD -->
    <div class="col-lg-4">

        <div class="card-dashboard p-4 text-center h-100">

            <img src="<?= $foto ?>" class="rounded-circle shadow-sm mb-3" width="130" height="130"
                style="object-fit:cover;">

            <h4 class="fw-bold mb-1">

                <?= $nama ?>

            </h4>

            <p class="text-muted mb-3">

                <?= $email ?>

            </p>

            <span class="badge bg-primary px-3 py-2 rounded-pill">

                <?= ucfirst($_SESSION['role']) ?>

            </span>

            <hr>

            <small class="text-muted">

                Payroll Management System

            </small>

        </div>

    </div>


    <!-- FORM -->
    <div class="col-lg-8">

        <div class="card-dashboard p-4">

            <!-- HEADER -->
            <div class="mb-4">

                <h5 class="fw-bold mb-1">

                    Pengaturan Profil

                </h5>

                <p class="text-muted small mb-0">

                    Perbarui informasi akun Anda

                </p>

            </div>


            <!-- FORM -->
            <form method="POST" enctype="multipart/form-data">

                <div class="row g-3">

                    <!-- NAMA -->
                    <div class="col-md-12">

                        <label class="form-label">

                            Nama Lengkap

                        </label>

                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $nama ?>" required>

                    </div>


                    <!-- EMAIL -->
                    <div class="col-md-12">

                        <label class="form-label">

                            Email

                        </label>

                        <input type="email" name="email" class="form-control" value="<?= $email ?>" required>

                    </div>


                    <!-- ROLE -->
                    <div class="col-md-12">

                        <label class="form-label">

                            Role

                        </label>

                        <input type="text" class="form-control" value="<?= ucfirst($_SESSION['role']) ?>" readonly>

                    </div>


                    <!-- FOTO -->
                    <div class="col-md-12">

                        <label class="form-label">

                            Foto Profil

                        </label>

                        <input type="file" name="foto_profil" class="form-control" accept=".jpg,.jpeg,.png">

                        <small class="text-muted">

                            Format JPG, JPEG, PNG.
                            Maksimal 2MB.

                        </small>

                    </div>


                    <!-- BUTTON -->
                    <div class="col-md-12 d-flex justify-content-end gap-2 pt-3">

                        <button type="reset" class="btn btn-light rounded-3">

                            Reset

                        </button>

                        <button type="submit" name="simpan_profil" class="btn btn-primary rounded-3">

                            <i class="fa-solid fa-floppy-disk me-2"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

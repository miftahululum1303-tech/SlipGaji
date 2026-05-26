<?php

include 'pages/karyawan/tambah.php';

include 'pages/karyawan/edit.php';

include 'pages/karyawan/hapus.php';

?>


<div class="card-dashboard p-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Data Karyawan

            </h5>

            <p class="text-muted small mb-0">

                Kelola seluruh data karyawan perusahaan

            </p>

        </div>

        <button class="btn btn-primary rounded-3" data-bs-toggle="collapse" data-bs-target="#formTambahKaryawan">

            <i class="fa-solid fa-user-plus me-2"></i>

            Tambah Karyawan

        </button>

    </div>


    <!-- FORM -->
    <div class="collapse mb-4" id="formTambahKaryawan">

        <div class="border rounded-4 p-4 bg-light">

            <form method="POST">

                <div class="row g-3">

                    <div class="col-md-10">

                        <label class="form-label">

                            Nama Karyawan

                        </label>

                        <input type="text" name="nama" class="form-control" required>

                    </div>

                    <div class="col-md-2 d-grid">

                        <label class="form-label invisible">
                            Button
                        </label>

                        <button type="submit" name="simpan_karyawan" class="btn btn-success">

                            Simpan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- TABLE -->
    <div class="table-responsive">

        <table class="table table-hover align-middle datatable">

            <thead class="table-light">

                <tr>

                    <th>No</th>

                    <th>NIK</th>

                    <th>Nama Karyawan</th>

                    <th>Username</th>

                    <th class="no-sort text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php

                $no = 1;

                $sql = mysqli_query(

                    $koneksi,

                    "SELECT
                        karyawan.*,
                        users.username
                     FROM karyawan
                     LEFT JOIN users
                     ON users.id_karyawan =
                        karyawan.id_karyawan
                     ORDER BY
                        karyawan.id_karyawan DESC"

                );

                while ($row = mysqli_fetch_assoc($sql)) {

                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>
                        <code>
                            <?= $row['nik'] ?>
                        </code>
                    </td>

                    <td class="fw-semibold">
                        <?= $row['nama_karyawan'] ?>
                    </td>

                    <td>
                        <?= $row['username'] ?>
                    </td>

                    <td class="text-center">

                        <!-- DETAIL -->
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                            data-bs-target="#akun<?= $row['id_karyawan'] ?>">

                            <i class="fa-solid fa-eye"></i>

                        </button>

                        <!-- EDIT -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_karyawan'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- RESET -->
                        <a href="index.php?page=karyawan&action=reset&id=<?= $row['id_karyawan'] ?>"
                            class="btn btn-warning btn-sm text-white" data-delete="true"
                            data-message="Reset password menjadi 123456?">

                            <i class="fa-solid fa-rotate"></i>

                        </a>

                        <!-- HAPUS -->
                        <a href="index.php?page=karyawan&action=hapus&id=<?= $row['id_karyawan'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true" data-message="Hapus data karyawan ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<?php include 'pages/karyawan/modal.php'; ?>

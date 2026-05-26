<?php

include 'pages/jabatan/tambah.php';

include 'pages/jabatan/edit.php';

include 'pages/jabatan/hapus.php';

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Data Jabatan

            </h5>

            <p class="text-muted small mb-0">

                Kelola data jabatan dan gaji pokok karyawan

            </p>

        </div>

        <button class="btn btn-primary rounded-3" data-bs-toggle="collapse" data-bs-target="#formTambahJabatan">

            <i class="fa-solid fa-briefcase me-2"></i>

            Tambah Jabatan

        </button>

    </div>


    <!-- FORM -->
    <div class="collapse mb-4" id="formTambahJabatan">

        <div class="border rounded-4 p-4 bg-light">

            <form method="POST">

                <div class="row g-3">

                    <!-- NAMA -->
                    <div class="col-md-4">

                        <label class="form-label">

                            Nama Jabatan

                        </label>

                        <input type="text" name="nama_jabatan" class="form-control"
                            placeholder="Masukkan nama jabatan" required>

                    </div>

                    <!-- GAJI -->
                    <div class="col-md-3">

                        <label class="form-label">

                            Gaji Pokok

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="gaji_pokok" class="form-control" placeholder="0" required>

                        </div>

                    </div>

                    <!-- TUNJANGAN -->
                    <div class="col-md-3">

                        <label class="form-label">

                            Tunjangan Jabatan

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="tunjangan_jabatan" class="form-control" placeholder="0"
                                required>

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="col-md-2 d-grid">

                        <label class="form-label invisible">
                            Button
                        </label>

                        <button type="submit" name="simpan_jabatan" class="btn btn-success">

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

                    <th width="10%">
                        No
                    </th>

                    <th>
                        Nama Jabatan
                    </th>

                    <th>
                        Gaji Pokok
                    </th>

                    <th>
                        Tunjangan
                    </th>

                    <th class="text-center no-sort">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php

                $no = 1;

                $sql = mysqli_query(

                    $koneksi,

                    "SELECT *
                     FROM jabatan
                     ORDER BY id_jabatan DESC"

                );

                while ($row = mysqli_fetch_assoc($sql)) {

                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>

                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">

                            <?= $row['nama_jabatan'] ?>

                        </span>

                    </td>

                    <td class="fw-bold text-success">

                        Rp
                        <?= number_format($row['gaji_pokok'], 0, ',', '.') ?>

                    </td>

                    <td class="fw-bold text-primary">

                        Rp
                        <?= number_format($row['tunjangan_jabatan'], 0, ',', '.') ?>

                    </td>

                    <td class="text-center">

                        <!-- EDIT -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_jabatan'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- HAPUS -->
                        <a href="index.php?page=jabatan&action=hapus&id=<?= $row['id_jabatan'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true" data-message="Hapus data jabatan ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<?php include 'pages/jabatan/modal.php'; ?>

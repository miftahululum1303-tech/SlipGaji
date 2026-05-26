<?php

include 'pages/golongan/tambah.php';

include 'pages/golongan/edit.php';

include 'pages/golongan/hapus.php';

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Data Golongan

            </h5>

            <p class="text-muted small mb-0">

                Kelola data tunjangan golongan karyawan

            </p>

        </div>

        <button class="btn btn-primary rounded-3" data-bs-toggle="collapse" data-bs-target="#formTambahGolongan">

            <i class="fa-solid fa-layer-group me-2"></i>

            Tambah Golongan

        </button>

    </div>


    <!-- FORM -->
    <div class="collapse mb-4" id="formTambahGolongan">

        <div class="border rounded-4 p-4 bg-light">

            <form method="POST">

                <div class="row g-3">

                    <!-- NAMA -->
                    <div class="col-md-5">

                        <label class="form-label">

                            Nama Golongan

                        </label>

                        <input type="text" name="nama_golongan" class="form-control"
                            placeholder="Masukkan nama golongan" required>

                    </div>

                    <!-- TUNJANGAN -->
                    <div class="col-md-5">

                        <label class="form-label">

                            Tunjangan Golongan

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="tunjangan_golongan" class="form-control" placeholder="0"
                                required>

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="col-md-2 d-grid">

                        <label class="form-label invisible">
                            Button
                        </label>

                        <button type="submit" name="simpan_golongan" class="btn btn-success">

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
                        Nama Golongan
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
                     FROM golongan
                     ORDER BY id_golongan DESC"

                );

                while ($row = mysqli_fetch_assoc($sql)) {

                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>

                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">

                            <?= $row['nama_golongan'] ?>

                        </span>

                    </td>

                    <td class="fw-bold text-success">

                        Rp
                        <?= number_format($row['tunjangan_golongan'], 0, ',', '.') ?>

                    </td>

                    <td class="text-center">

                        <!-- EDIT -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_golongan'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- HAPUS -->
                        <a href="index.php?page=golongan&action=hapus&id=<?= $row['id_golongan'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true" data-message="Hapus data golongan ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<?php include 'pages/golongan/modal.php'; ?>

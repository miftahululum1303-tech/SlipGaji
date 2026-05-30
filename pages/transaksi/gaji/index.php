<?php

include 'pages/transaksi/gaji/generate.php';
include 'pages/transaksi/gaji/modal.php';
include 'pages/transaksi/gaji/hapus.php';

?>


<div class="card-dashboard p-4 mb-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Transaksi Gaji

            </h5>

            <p class="text-muted small mb-0">

                Generate payroll dan slip gaji karyawan

            </p>

        </div>

    </div>

    <form method="POST">

        <div class="row g-3">

            <!-- PERIODE -->
            <div class="col-md-10">

                <label class="form-label">

                    Periode Gaji

                </label>

                <input type="month" name="periode" class="form-control" required>

            </div>


            <!-- BUTTON -->
            <div class="col-md-2 d-grid">

                <label class="form-label invisible">

                    Button

                </label>

                <button type="submit" name="generate_semua_gaji" class="btn btn-success">

                    <i class="fa-solid fa-bolt me-2"></i>

                    Generate

                </button>

            </div>

        </div>

    </form>

</div>


<!-- TABLE -->
<div class="card-dashboard p-4">

    <div class="table-responsive">

        <table class="table table-hover align-middle datatable">

            <thead class="table-light">

                <tr>

                    <th>No</th>

                    <th>NIK</th>

                    <th>Nama Karyawan</th>

                    <th>Periode</th>

                    <th>Total Gaji</th>

                    <th>Tanggal Gaji</th>

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

                    "SELECT

                        tg.*,

                        k.nik,
                        k.nama_karyawan

                     FROM transaksi_gaji tg

                     INNER JOIN karyawan k
                        ON tg.id_karyawan =
                           k.id_karyawan

                     ORDER BY
                        tg.id_gaji DESC"

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

                        <?= $row['periode'] ?>

                    </td>

                    <td class="fw-bold text-success">

                        Rp
                        <?= number_format($row['total_gaji'], 0, ',', '.') ?>

                    </td>

                    <td>

                        <?= date('d M Y', strtotime($row['tanggal_gaji'])) ?>

                    </td>

                    <td class="text-center">
                        <!-- EDIT -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editPayroll<?= $row['id_gaji'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>
                        <!-- DETAIL -->
                        <a href="index.php?page=detail_gaji&id=<?= $row['id_gaji'] ?>"
                            class="btn btn-info btn-sm text-white">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        <!-- PRINT -->
                        <a href="pages/slip_gaji_print.php?id=<?= $row['id_gaji'] ?>" target="_blank"
                            class="btn btn-primary btn-sm">

                            <i class="fa-solid fa-print"></i>

                        </a>

                        <!-- HAPUS -->
                        <a href="index.php?page=transaksi_gaji&action=hapus&id=<?= $row['id_gaji'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true" data-message="Hapus transaksi gaji ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

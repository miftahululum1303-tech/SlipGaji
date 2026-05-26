<?php

include 'pages/transaksi/jabatan/tambah.php';

include 'pages/transaksi/jabatan/edit.php';

include 'pages/transaksi/jabatan/hapus.php';

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Transaksi Jabatan

            </h5>

            <p class="text-muted small mb-0">

                Pemetaan jabatan untuk setiap karyawan

            </p>

        </div>

        <button class="btn btn-primary rounded-3" data-bs-toggle="collapse" data-bs-target="#formTransaksiJabatan">

            <i class="fa-solid fa-briefcase me-2"></i>

            Tambah Transaksi

        </button>

    </div>


    <!-- FORM -->
    <div class="collapse mb-4" id="formTransaksiJabatan">

        <div class="border rounded-4 p-4 bg-light">

            <form method="POST">

                <div class="row g-3">

                    <!-- KARYAWAN -->
                    <div class="col-md-5">

                        <label class="form-label">

                            Pilih Karyawan

                        </label>

                        <select name="id_karyawan" class="form-select" required>

                            <option value="">
                                -- Pilih Karyawan --
                            </option>

                            <?php

                            $karyawan = mysqli_query(

                                $koneksi,

                                "SELECT *
                                 FROM karyawan
                                 ORDER BY nama_karyawan ASC"

                            );

                            while ($k = mysqli_fetch_assoc($karyawan)) {

                            ?>

                            <option value="<?= $k['id_karyawan'] ?>">

                                <?= $k['nik'] ?>
                                -
                                <?= $k['nama_karyawan'] ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- JABATAN -->
                    <div class="col-md-5">

                        <label class="form-label">

                            Pilih Jabatan

                        </label>

                        <select name="id_jabatan" class="form-select" required>

                            <option value="">
                                -- Pilih Jabatan --
                            </option>

                            <?php

                            $jabatan = mysqli_query(

                                $koneksi,

                                "SELECT *
                                 FROM jabatan
                                 ORDER BY nama_jabatan ASC"

                            );

                            while ($j = mysqli_fetch_assoc($jabatan)) {

                            ?>

                            <option value="<?= $j['id_jabatan'] ?>">

                                <?= $j['nama_jabatan'] ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- BUTTON -->
                    <div class="col-md-2 d-grid">

                        <label class="form-label invisible">
                            Button
                        </label>

                        <button type="submit" name="simpan_transaksi_jabatan" class="btn btn-success">

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
                        NIK
                    </th>

                    <th>
                        Nama Karyawan
                    </th>

                    <th>
                        Jabatan
                    </th>

                    <th>
                        Tanggal Mulai
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

                    "SELECT

                        tj.*,

                        k.nik,
                        k.nama_karyawan,

                        j.nama_jabatan

                     FROM transaksi_jabatan tj

                     INNER JOIN karyawan k
                        ON tj.id_karyawan =
                           k.id_karyawan

                     INNER JOIN jabatan j
                        ON tj.id_jabatan =
                           j.id_jabatan

                     ORDER BY
                        tj.id_transaksi_jabatan DESC"

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

                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">

                            <?= $row['nama_jabatan'] ?>

                        </span>

                    </td>

                    <td>

                        <?= date('d M Y', strtotime($row['tanggal_mulai'])) ?>

                    </td>

                    <td class="text-center">

                        <!-- EDIT -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_transaksi_jabatan'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- HAPUS -->
                        <a href="index.php?page=transaksi_jabatan&action=hapus&id=<?= $row['id_transaksi_jabatan'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true"
                            data-message="Hapus transaksi jabatan ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<?php include 'pages/transaksi/jabatan/modal.php'; ?>

<?php

include 'pages/transaksi/golongan/tambah.php';

include 'pages/transaksi/golongan/edit.php';

include 'pages/transaksi/golongan/hapus.php';

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h5 class="fw-bold mb-1">

                Transaksi Golongan

            </h5>

            <p class="text-muted small mb-0">

                Pemetaan golongan untuk setiap karyawan

            </p>

        </div>

        <button class="btn btn-primary rounded-3" data-bs-toggle="collapse" data-bs-target="#formTransaksiGolongan">

            <i class="fa-solid fa-layer-group me-2"></i>

            Tambah Transaksi

        </button>

    </div>


    <!-- FORM -->
    <div class="collapse mb-4" id="formTransaksiGolongan">

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


                    <!-- GOLONGAN -->
                    <div class="col-md-5">

                        <label class="form-label">

                            Pilih Golongan

                        </label>

                        <select name="id_golongan" class="form-select" required>

                            <option value="">
                                -- Pilih Golongan --
                            </option>

                            <?php

                            $golongan = mysqli_query(

                                $koneksi,

                                "SELECT *
                                 FROM golongan
                                 ORDER BY nama_golongan ASC"

                            );

                            while ($g = mysqli_fetch_assoc($golongan)) {

                            ?>

                            <option value="<?= $g['id_golongan'] ?>">

                                <?= $g['nama_golongan'] ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- BUTTON -->
                    <div class="col-md-2 d-grid">

                        <label class="form-label invisible">
                            Button
                        </label>

                        <button type="submit" name="simpan_transaksi_golongan" class="btn btn-success">

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
                        Golongan
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

                        tg.*,

                        k.nik,
                        k.nama_karyawan,

                        g.nama_golongan

                     FROM transaksi_golongan tg

                     INNER JOIN karyawan k
                        ON tg.id_karyawan =
                           k.id_karyawan

                     INNER JOIN golongan g
                        ON tg.id_golongan =
                           g.id_golongan

                     ORDER BY
                        tg.id_transaksi_golongan DESC"

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

                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">

                            <?= $row['nama_golongan'] ?>

                        </span>

                    </td>

                    <td>

                        <?= date('d M Y', strtotime($row['tanggal_mulai'])) ?>

                    </td>

                    <td class="text-center">

                        <!-- EDIT -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_transaksi_golongan'] ?>">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- HAPUS -->
                        <a href="index.php?page=transaksi_golongan&action=hapus&id=<?= $row['id_transaksi_golongan'] ?>"
                            class="btn btn-danger btn-sm" data-delete="true"
                            data-message="Hapus transaksi golongan ini?">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<?php include 'pages/transaksi/golongan/modal.php'; ?>

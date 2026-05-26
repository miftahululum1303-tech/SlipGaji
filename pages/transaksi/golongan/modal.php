<?php

$queryModal = mysqli_query(

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


while ($row = mysqli_fetch_assoc($queryModal)) {

?>

<!-- ========================================
         MODAL EDIT TRANSAKSI GOLONGAN
    ======================================== -->

<div class="modal fade" id="edit<?= $row['id_transaksi_golongan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <form method="POST">

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Edit Transaksi Golongan

                        </h5>

                        <small class="text-muted">

                            Perbarui pemetaan golongan karyawan

                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body pt-3">

                    <input type="hidden" name="id_transaksi_golongan" value="<?= $row['id_transaksi_golongan'] ?>">


                    <!-- KARYAWAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Karyawan

                        </label>

                        <select name="id_karyawan" class="form-select" required>

                            <?php

                                $karyawan = mysqli_query(

                                    $koneksi,

                                    "SELECT *
                                     FROM karyawan
                                     ORDER BY nama_karyawan ASC"

                                );

                                while ($k = mysqli_fetch_assoc($karyawan)) {

                                ?>

                            <option value="<?= $k['id_karyawan'] ?>"
                                <?= $k['id_karyawan'] == $row['id_karyawan'] ? 'selected' : '' ?>>

                                <?= $k['nik'] ?>
                                -
                                <?= $k['nama_karyawan'] ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- GOLONGAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Golongan

                        </label>

                        <select name="id_golongan" class="form-select" required>

                            <?php

                                $golongan = mysqli_query(

                                    $koneksi,

                                    "SELECT *
                                     FROM golongan
                                     ORDER BY nama_golongan ASC"

                                );

                                while ($g = mysqli_fetch_assoc($golongan)) {

                                ?>

                            <option value="<?= $g['id_golongan'] ?>"
                                <?= $g['id_golongan'] == $row['id_golongan'] ? 'selected' : '' ?>>

                                <?= $g['nama_golongan'] ?>

                            </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- TANGGAL -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Mulai

                        </label>

                        <input type="text" class="form-control"
                            value="<?= date('d F Y', strtotime($row['tanggal_mulai'])) ?>" readonly>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" name="update_transaksi_golongan" class="btn btn-primary rounded-3">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

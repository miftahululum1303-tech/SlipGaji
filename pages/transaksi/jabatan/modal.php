<?php

$queryModal = mysqli_query(

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


while ($row = mysqli_fetch_assoc($queryModal)) {

?>

<!-- ========================================
         MODAL EDIT TRANSAKSI JABATAN
    ======================================== -->

<div class="modal fade" id="edit<?= $row['id_transaksi_jabatan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <form method="POST">

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Edit Transaksi Jabatan

                        </h5>

                        <small class="text-muted">

                            Perbarui pemetaan jabatan karyawan

                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body pt-3">

                    <input type="hidden" name="id_transaksi_jabatan" value="<?= $row['id_transaksi_jabatan'] ?>">


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


                    <!-- JABATAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Jabatan

                        </label>

                        <select name="id_jabatan" class="form-select" required>

                            <?php

                                $jabatan = mysqli_query(

                                    $koneksi,

                                    "SELECT *
                                     FROM jabatan
                                     ORDER BY nama_jabatan ASC"

                                );

                                while ($j = mysqli_fetch_assoc($jabatan)) {

                                ?>

                            <option value="<?= $j['id_jabatan'] ?>"
                                <?= $j['id_jabatan'] == $row['id_jabatan'] ? 'selected' : '' ?>>

                                <?= $j['nama_jabatan'] ?>

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

                    <button type="submit" name="update_transaksi_jabatan" class="btn btn-primary rounded-3">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

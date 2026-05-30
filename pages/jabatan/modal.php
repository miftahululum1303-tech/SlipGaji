<?php

$queryModal = mysqli_query(

    $koneksi,

    "SELECT *
     FROM jabatan
     ORDER BY id_jabatan DESC"

);


while ($row = mysqli_fetch_assoc($queryModal)) {

?>

<!-- ========================================
         MODAL EDIT JABATAN
    ======================================== -->

<div class="modal fade" id="edit<?= $row['id_jabatan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <form method="POST">

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Edit Data Jabatan

                        </h5>

                        <small class="text-muted">

                            Perbarui data jabatan karyawan

                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body pt-3">

                    <input type="hidden" name="id_jabatan" value="<?= $row['id_jabatan'] ?>">


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Nama Jabatan

                        </label>

                        <input type="text" name="nama_jabatan" class="form-control"
                            value="<?= $row['nama_jabatan'] ?>" required>

                    </div>

                    <!-- TUNJANGAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Tunjangan Jabatan

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="tunjangan_jabatan" class="form-control"
                                value="<?= $row['tunjangan_jabatan'] ?>" required>

                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" name="update_jabatan" class="btn btn-primary rounded-3">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

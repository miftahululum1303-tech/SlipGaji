<?php

$queryModal = mysqli_query(

    $koneksi,

    "SELECT *
     FROM golongan
     ORDER BY id_golongan DESC"

);


while ($row = mysqli_fetch_assoc($queryModal)) {

?>

<!-- ========================================
         MODAL EDIT GOLONGAN
    ======================================== -->

<div class="modal fade" id="edit<?= $row['id_golongan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <form method="POST">

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Edit Data Golongan

                        </h5>

                        <small class="text-muted">

                            Perbarui data golongan karyawan

                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body pt-3">

                    <input type="hidden" name="id_golongan" value="<?= $row['id_golongan'] ?>">


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Nama Golongan

                        </label>

                        <input type="text" name="nama_golongan" class="form-control"
                            value="<?= $row['nama_golongan'] ?>" required>

                    </div>


                    <!-- TUNJANGAN -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Tunjangan Golongan

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="gaji_pokok" class="form-control"
                                value="<?= $row['gaji_pokok'] ?>" required>

                        </div>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" name="update_golongan" class="btn btn-primary rounded-3">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

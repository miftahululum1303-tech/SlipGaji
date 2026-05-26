<?php

$queryModal = mysqli_query(

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


while ($row = mysqli_fetch_assoc($queryModal)) {

?>

<!-- ========================================
         MODAL DETAIL AKUN
    ======================================== -->

<div class="modal fade" id="akun<?= $row['id_karyawan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">

                <div>

                    <h5 class="fw-bold mb-1">

                        Detail Akun Karyawan

                    </h5>

                    <small class="text-muted">

                        Informasi login karyawan

                    </small>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>


            <!-- BODY -->
            <div class="modal-body pt-3">

                <div class="text-center mb-4">

                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                        style="width:80px;height:80px;">

                        <i class="fa-solid fa-user fs-2"></i>

                    </div>

                    <h5 class="fw-bold mb-1">

                        <?= $row['nama_karyawan'] ?>

                    </h5>

                    <small class="text-muted">

                        <?= $row['nik'] ?>

                    </small>

                </div>


                <div class="border rounded-4 p-3">

                    <div class="mb-3">

                        <small class="text-muted d-block mb-1">

                            Username Login

                        </small>

                        <code class="fs-6">

                            <?= $row['username'] ?>

                        </code>

                    </div>

                    <div>

                        <small class="text-muted d-block mb-1">

                            Password Default

                        </small>

                        <span class="badge bg-warning text-dark">

                            123456

                        </span>

                    </div>

                </div>

            </div>


            <!-- FOOTER -->
            <div class="modal-footer border-0 pt-0">

                <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ========================================
         MODAL EDIT
    ======================================== -->

<div class="modal fade" id="edit<?= $row['id_karyawan'] ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <form method="POST">

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Edit Data Karyawan

                        </h5>

                        <small class="text-muted">

                            Perbarui data identitas karyawan

                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body pt-3">

                    <input type="hidden" name="id_karyawan" value="<?= $row['id_karyawan'] ?>">


                    <!-- NIK -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            NIK

                        </label>

                        <input type="text" class="form-control" value="<?= $row['nik'] ?>" readonly>

                    </div>


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Nama Karyawan

                        </label>

                        <input type="text" name="nama" class="form-control" value="<?= $row['nama_karyawan'] ?>"
                            required>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" name="update_karyawan" class="btn btn-primary rounded-3">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

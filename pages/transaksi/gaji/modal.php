<?php

$sqlModal = mysqli_query(

    $koneksi,

    "SELECT

        tg.*,

        k.nama_karyawan

     FROM transaksi_gaji tg

     INNER JOIN karyawan k
        ON tg.id_karyawan =
           k.id_karyawan"

);

while ($m = mysqli_fetch_assoc($sqlModal)) {

?>

<div class="modal fade" id="editPayroll<?= $m['id_gaji'] ?>" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content border-0 rounded-4">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Edit Payroll

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>


            <!-- FORM -->
            <form method="POST">

                <div class="modal-body">

                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">

                            Karyawan

                        </label>

                        <input type="text" class="form-control" value="<?= $m['nama_karyawan'] ?>" readonly>

                    </div>


                    <!-- BONUS -->
                    <div class="mb-3">

                        <label class="form-label">

                            Bonus

                        </label>

                        <input type="number" name="bonus" class="form-control" value="<?= $m['bonus'] ?>" required>

                    </div>


                    <!-- POTONGAN -->
                    <div class="mb-3">

                        <label class="form-label">

                            Potongan

                        </label>

                        <input type="number" name="potongan" class="form-control" value="<?= $m['potongan'] ?>"
                            required>

                    </div>


                    <input type="hidden" name="id_gaji" value="<?= $m['id_gaji'] ?>">

                </div>


                <!-- FOOTER -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" name="update_payroll" class="btn btn-warning">

                        Update Payroll

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>

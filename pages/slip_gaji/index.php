<?php

$idKaryawan = $_SESSION['id_karyawan'];

?>


<!-- ========================================
     HEADER
======================================== -->

<div class="card-dashboard p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <h4 class="fw-bold mb-1">

                Slip Gaji Saya

            </h4>

            <p class="text-muted small mb-0">

                Riwayat payroll dan slip gaji karyawan

            </p>

        </div>

    </div>

</div>


<!-- ========================================
     TABLE SLIP
======================================== -->

<div class="card-dashboard p-4">

    <div class="table-responsive">

        <table class="table table-hover align-middle datatable">

            <thead class="table-light">

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th>
                        Periode
                    </th>

                    <th>
                        Total Gaji
                    </th>

                    <th>
                        Tanggal Gaji
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
                     FROM transaksi_gaji

                     WHERE
                        id_karyawan='$idKaryawan'

                     ORDER BY
                        id_gaji DESC"

                );


                while ($row = mysqli_fetch_assoc($sql)) {

                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>

                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">

                            <?= $row['periode'] ?>

                        </span>

                    </td>

                    <td class="fw-bold text-success">

                        Rp
                        <?= number_format($row['total_gaji'], 0, ',', '.') ?>

                    </td>

                    <td>

                        <?= date('d M Y', strtotime($row['tanggal_gaji'])) ?>

                    </td>

                    <td class="text-center">

                        <!-- DETAIL -->
                        <a href="index.php?page=detail_slip&id=<?= $row['id_gaji'] ?>"
                            class="btn btn-info btn-sm text-white">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        <!-- PRINT -->
                        <a href="pages/slip_gaji_print.php?id=<?= $row['id_gaji'] ?>" target="_blank"
                            class="btn btn-primary btn-sm">

                            <i class="fa-solid fa-print"></i>

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

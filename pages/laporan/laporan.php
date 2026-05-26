<?php

/* ========================================
   FILTER PERIODE
======================================== */

$filterPeriode = trim($_GET['periode'] ?? '');

?>


<!-- ========================================
     HEADER LAPORAN
======================================== -->

<div class="card-dashboard p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <h4 class="fw-bold mb-1">

                Laporan Payroll

            </h4>

            <p class="text-muted small mb-0">

                Rekap seluruh transaksi payroll karyawan

            </p>

        </div>

        <!-- PRINT -->
        <button onclick="window.print()" class="btn btn-dark rounded-3">

            <i class="fa-solid fa-print me-2"></i>

            Print Laporan

        </button>

    </div>

</div>


<!-- ========================================
     FILTER
======================================== -->

<div class="card-dashboard p-4 mb-4">

    <form method="GET">

        <input type="hidden" name="page" value="laporan">

        <div class="row g-3 align-items-end">

            <!-- PERIODE -->
            <div class="col-md-4">

                <label class="form-label">

                    Filter Periode

                </label>

                <input type="month" name="periode" class="form-control" value="<?= $filterPeriode ?>">

            </div>


            <!-- BUTTON -->
            <div class="col-md-2 d-grid">

                <button type="submit" class="btn btn-primary rounded-3">

                    <i class="fa-solid fa-filter me-2"></i>

                    Tampilkan

                </button>

            </div>

        </div>

    </form>

</div>


<!-- ========================================
     TABLE LAPORAN
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
                        NIK
                    </th>

                    <th>
                        Nama Karyawan
                    </th>

                    <th>
                        Jabatan
                    </th>

                    <th>
                        Golongan
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

                </tr>

            </thead>

            <tbody>

                <?php

                /* ========================================
                   FILTER QUERY
                ======================================== */

                $where = '';

                if (!empty($filterPeriode)) {

                    $where =
                        "WHERE tg.periode='$filterPeriode'";
                }


                /* ========================================
                   QUERY DATA
                ======================================== */

                $sql = mysqli_query(

                    $koneksi,

                    "SELECT

                        tg.*,

                        k.nik,
                        k.nama_karyawan,

                        j.nama_jabatan,

                        g.nama_golongan

                     FROM transaksi_gaji tg

                     INNER JOIN karyawan k
                        ON tg.id_karyawan =
                           k.id_karyawan

                     INNER JOIN transaksi_jabatan tj
                        ON k.id_karyawan =
                           tj.id_karyawan

                     INNER JOIN jabatan j
                        ON tj.id_jabatan =
                           j.id_jabatan

                     INNER JOIN transaksi_golongan trg
                        ON k.id_karyawan =
                           trg.id_karyawan

                     INNER JOIN golongan g
                        ON trg.id_golongan =
                           g.id_golongan

                     $where

                     ORDER BY
                        tg.id_gaji DESC"

                );


                $no = 1;

                $grandTotal = 0;


                while ($row = mysqli_fetch_assoc($sql)) {

                    $grandTotal +=
                        $row['total_gaji'];

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

                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">

                            <?= $row['nama_golongan'] ?>

                        </span>

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

                </tr>

                <?php } ?>

            </tbody>


            <!-- FOOTER -->
            <tfoot class="table-light">

                <tr>

                    <th colspan="6" class="text-end">

                        Total Pengeluaran Payroll

                    </th>

                    <th class="text-success fw-bold">

                        Rp
                        <?= number_format($grandTotal, 0, ',', '.') ?>

                    </th>

                    <th></th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

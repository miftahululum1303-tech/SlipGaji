<?php

$filter_periode = '';

if (isset($_GET['periode'])) {
    $filter_periode = $_GET['periode'];
}

?>

<div class="card card-premium p-4 rounded-4 mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div>
            <h5 class="fw-bold m-0">
                <i class="fa-solid fa-file-waveform me-2"></i>
                Laporan Payroll Karyawan
            </h5>

            <small class="text-muted">
                Rekap keseluruhan transaksi gaji karyawan
            </small>
        </div>

        <button onclick="window.print()" class="btn btn-dark">
            <i class="fa-solid fa-print me-2"></i>
            Print Laporan
        </button>

    </div>

    <hr>

    <form method="GET">

        <input type="hidden" name="page" value="laporan">

        <div class="row g-3 align-items-end">

            <div class="col-md-4">

                <label class="form-label">
                    Filter Periode
                </label>

                <input type="month" name="periode" class="form-control" value="<?= $filter_periode ?>">

            </div>

            <div class="col-md-2 d-grid">

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-filter me-2"></i>
                    Tampilkan
                </button>

            </div>

        </div>

    </form>

</div>

<div class="card card-premium p-4 rounded-4">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Golongan</th>
                    <th>Total Gaji</th>
                    <th>Tanggal Gaji</th>
                </tr>

            </thead>

            <tbody>

                <?php

                $where = '';

                if ($filter_periode != '') {
                    $where = "WHERE tg.periode='$filter_periode'";
                }

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
                        ON tg.id_karyawan = k.id_karyawan

                    INNER JOIN transaksi_jabatan tj
                        ON k.id_karyawan = tj.id_karyawan

                    INNER JOIN jabatan j
                        ON tj.id_jabatan = j.id_jabatan

                    INNER JOIN transaksi_golongan trg
                        ON k.id_karyawan = trg.id_karyawan

                    INNER JOIN golongan g
                        ON trg.id_golongan = g.id_golongan

                    $where

                    ORDER BY tg.id_gaji DESC"
                );

                $no = 1;
                $grand_total = 0;

                while ($row = mysqli_fetch_array($sql)) {

                    $grand_total += $row['total_gaji'];

                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $row['nik'] ?></td>

                    <td><?= $row['nama_karyawan'] ?></td>

                    <td><?= $row['nama_jabatan'] ?></td>

                    <td><?= $row['nama_golongan'] ?></td>

                    <td class="fw-bold text-success">
                        Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?>
                    </td>

                    <td>
                        <?= date('d M Y', strtotime($row['tanggal_gaji'])) ?>
                    </td>

                </tr>

                <?php } ?>

            </tbody>

            <tfoot class="table-light">

                <tr>

                    <th colspan="5" class="text-end">
                        Total Pengeluaran Payroll
                    </th>

                    <th class="text-success fw-bold">
                        Rp <?= number_format($grand_total, 0, ',', '.') ?>
                    </th>

                    <th></th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

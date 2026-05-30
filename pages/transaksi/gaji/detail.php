<?php

/* ========================================
   VALIDASI ID
======================================== */

$idGaji = intval($_GET['id'] ?? 0);

if ($idGaji <= 0) {
    echo "

    <script>

        alert(
            'ID payroll tidak valid'
        );

        window.location =
            'index.php?page=transaksi_gaji';

    </script>

    ";

    exit();
}

/* ========================================
   AMBIL DATA PAYROLL
======================================== */

$query = mysqli_query(
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

     WHERE
        tg.id_gaji='$idGaji'

     LIMIT 1",
);

$data = mysqli_fetch_assoc($query);

/* ========================================
   VALIDASI DATA
======================================== */

if (!$data) {
    echo "

    <script>

        alert(
            'Data payroll tidak ditemukan'
        );

        window.location =
            'index.php?page=transaksi_gaji';

    </script>

    ";

    exit();
}

?>


<div class="card-dashboard p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h4 class="fw-bold mb-1">

                Detail Slip Gaji

            </h4>

            <p class="text-muted small mb-0">

                Informasi detail payroll karyawan

            </p>

        </div>

        <div class="d-flex gap-2">

            <!-- PRINT -->
            <a href="pages/slip_gaji_print.php?id=<?= $data['id_gaji'] ?>" target="_blank"
                class="btn btn-primary rounded-3">

                <i class="fa-solid fa-print me-2"></i>

                Print Slip

            </a>

            <!-- KEMBALI -->
            <a href="index.php?page=transaksi_gaji" class="btn btn-light rounded-3">

                Kembali

            </a>

        </div>

    </div>


    <!-- IDENTITAS -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="border rounded-4 p-3 h-100">

                <small class="text-muted d-block mb-1">

                    NIK

                </small>

                <h6 class="fw-bold mb-0">

                    <?= $data['nik'] ?>

                </h6>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded-4 p-3 h-100">

                <small class="text-muted d-block mb-1">

                    Nama Karyawan

                </small>

                <h6 class="fw-bold mb-0">

                    <?= $data['nama_karyawan'] ?>

                </h6>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded-4 p-3 h-100">

                <small class="text-muted d-block mb-1">

                    Jabatan

                </small>

                <h6 class="fw-bold mb-0">

                    <?= $data['nama_jabatan'] ?>

                </h6>

            </div>

        </div>


        <div class="col-md-3">

            <div class="border rounded-4 p-3 h-100">

                <small class="text-muted d-block mb-1">

                    Golongan

                </small>

                <h6 class="fw-bold mb-0">

                    <?= $data['nama_golongan'] ?>

                </h6>

            </div>

        </div>

    </div>

    <!-- SUMMARY -->
    <div class="row g-3 mb-4">

        <!-- PERIODE -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <small class="text-muted d-block mb-2">

                        Periode Payroll

                    </small>

                    <h5 class="fw-bold text-primary mb-0">

                        <?= $data['periode'] ?>

                    </h5>

                </div>

            </div>

        </div>


        <!-- STATUS -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <small class="text-muted d-block mb-2">

                        Status Payroll

                    </small>

                    <span class="badge bg-success px-3 py-2 rounded-pill">

                        Sudah Dibayar

                    </span>

                </div>

            </div>

        </div>


        <!-- TANGGAL -->
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <small class="text-muted d-block mb-2">

                        Tanggal Payroll

                    </small>

                    <h6 class="fw-bold mb-0">

                        <?= date('d F Y', strtotime($data['tanggal_gaji'])) ?>

                    </h6>

                </div>

            </div>

        </div>

    </div>

    <!-- RINCIAN GAJI -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">

                <i class="fa-solid fa-wallet me-2 text-primary"></i>

                Rincian Payroll

            </h5>

            <div class="table-responsive">

                <table class="table align-middle">

                    <tbody>

                        <!-- GAJI POKOK -->
                        <tr>

                            <th width="70%">

                                Gaji Pokok

                            </th>

                            <td class="fw-bold text-primary">

                                Rp
                                <?= number_format($data['gaji_pokok'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <!-- TUNJANGAN -->
                        <tr>

                            <th>

                                Tunjangan Jabatan

                            </th>

                            <td class="fw-bold text-info">

                                Rp
                                <?= number_format($data['tunjangan_jabatan'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <!-- BONUS -->
                        <tr>

                            <th>

                                Bonus

                            </th>

                            <td class="fw-bold text-success">

                                Rp
                                <?= number_format($data['bonus'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <!-- POTONGAN -->
                        <tr>

                            <th>

                                Potongan

                            </th>

                            <td class="fw-bold text-danger">

                                Rp
                                <?= number_format($data['potongan'], 0, ',', '.') ?>

                            </td>

                        </tr>


                        <!-- TOTAL -->
                        <tr class="table-success">

                            <th class="fs-5">

                                Total Gaji

                            </th>

                            <td class="fw-bold fs-4">

                                Rp
                                <?= number_format($data['total_gaji'], 0, ',', '.') ?>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- FOOTER -->
    <div class="mt-4 text-muted small">

        <i class="fa-solid fa-clock me-2"></i>

        Payroll dibuat pada:

        <?= date('d F Y H:i', strtotime($data['tanggal_gaji'])) ?>

    </div>

</div>

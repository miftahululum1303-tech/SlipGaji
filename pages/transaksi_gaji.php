<?php
if (isset($_POST['generate_gaji'])) {
    $id_karyawan = intval($_POST['id_karyawan']);
    $periode = $_POST['periode'];
    $bonus = intval($_POST['bonus']);
    $potongan = intval($_POST['potongan']);

    // Ambil data jabatan
    $jabatan = mysqli_query(
        $koneksi,
        "SELECT
            j.gaji_pokok,
            j.tunjangan_jabatan
         FROM transaksi_jabatan tj
         INNER JOIN jabatan j
            ON tj.id_jabatan = j.id_jabatan
         WHERE tj.id_karyawan='$id_karyawan'",
    );

    // Ambil data golongan
    $golongan = mysqli_query(
        $koneksi,
        "SELECT
            g.tunjangan_golongan
         FROM transaksi_golongan tg
         INNER JOIN golongan g
            ON tg.id_golongan = g.id_golongan
         WHERE tg.id_karyawan='$id_karyawan'",
    );

    $j = mysqli_fetch_assoc($jabatan);
    $g = mysqli_fetch_assoc($golongan);

    if (!$j || !$g) {
        echo "<script>
        alert('Karyawan belum memiliki jabatan atau golongan!');
        window.location='index.php?page=transaksi_gaji';
    </script>";

        exit();
    }

    $gaji_pokok = isset($j['gaji_pokok']) ? $j['gaji_pokok'] : 0;
    $tunjangan_jabatan = isset($j['tunjangan_jabatan']) ? $j['tunjangan_jabatan'] : 0;
    $tunjangan_golongan = isset($g['tunjangan_golongan']) ? $g['tunjangan_golongan'] : 0;

    $total_gaji = $gaji_pokok + $tunjangan_jabatan + $tunjangan_golongan + $bonus - $potongan;

    mysqli_query($koneksi, "INSERT INTO transaksi_gaji (id_karyawan, periode, gaji_pokok, tunjangan_jabatan, tunjangan_golongan, bonus, potongan, total_gaji,tanggal_gaji) VALUES ('$id_karyawan', '$periode', '$gaji_pokok', '$tunjangan_jabatan', '$tunjangan_golongan', '$bonus', '$potongan', '$total_gaji', NOW())");

    echo "<script>
        alert('Payroll berhasil digenerate!');
        window.location='index.php?page=transaksi_gaji';
    </script>";
}
?>

<div class="card card-premium p-4 rounded-4 mb-4">
    <h5 class="fw-bold mb-3">
        <i class="fa-solid fa-money-bill-wave me-2"></i>
        Generate Payroll Karyawan
    </h5>
    <form method="POST">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">
                    Pilih Karyawan
                </label>
                <select name="id_karyawan" class="form-select" required>
                    <option value="">
                        -- Pilih Karyawan --
                    </option>
                    <?php
                    $karyawan = mysqli_query(
                        $koneksi,
                        "SELECT *
                         FROM karyawan
                         ORDER BY nama_karyawan ASC"
                    );

                    while ($k = mysqli_fetch_array($karyawan)) {
                    ?>

                    <option value="<?= $k['id_karyawan'] ?>">
                        <?= $k['nik'] ?> - <?= $k['nama_karyawan'] ?>
                    </option>

                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">
                    Periode Gaji
                </label>
                <input type="month" name="periode" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">
                    Bonus
                </label>
                <input type="number" name="bonus" class="form-control" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">
                    Potongan
                </label>
                <input type="number" name="potongan" class="form-control" value="0">
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" name="generate_gaji" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Generate Gaji
                </button>
            </div>
        </div>
    </form>
</div>

<?php
$sql = mysqli_query(
    $koneksi,
    "SELECT
        tg.*,

        k.nik,
        k.nama_karyawan,

        j.nama_jabatan,
        j.gaji_pokok,

        g.nama_golongan,
        g.tunjangan_golongan

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

     ORDER BY tg.id_gaji DESC"
);

while($row = mysqli_fetch_array($sql)) { ?>

<div class="card card-premium p-4 rounded-4 mb-4">

    <!-- HEADER -->
    <div class="row mb-4">

        <div class="col-md-4">
            <small class="text-muted">NIK</small>
            <h6 class="fw-bold"><?= $row['nik'] ?></h6>
        </div>

        <div class="col-md-4">
            <small class="text-muted">Nama Karyawan</small>
            <h6 class="fw-bold">
                <?= $row['nama_karyawan'] ?>
            </h6>
        </div>

        <div class="col-md-4">
            <small class="text-muted">Periode</small>
            <h6 class="fw-bold">
                <?= $row['periode'] ?>
            </h6>
        </div>

    </div>

    <!-- TABEL GOLONGAN -->
    <h6 class="fw-bold mb-3">
        <i class="fa-solid fa-layer-group me-2"></i>
        Berdasarkan Golongan
    </h6>

    <table class="table table-bordered">

        <thead class="table-light">
            <tr>
                <th>Golongan</th>
                <th width="30%">Nominal</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?= $row['nama_golongan'] ?></td>

                <td class="fw-bold text-success">
                    Rp <?= number_format($row['tunjangan_golongan'], 0, ',', '.') ?>
                </td>
            </tr>
        </tbody>

    </table>

    <!-- TABEL JABATAN -->
    <h6 class="fw-bold mb-3 mt-4">
        <i class="fa-solid fa-user-tie me-2"></i>
        Berdasarkan Jabatan
    </h6>

    <table class="table table-bordered">

        <thead class="table-light">
            <tr>
                <th>Jabatan</th>
                <th width="30%">Nominal</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?= $row['nama_jabatan'] ?></td>

                <td class="fw-bold text-primary">
                    Rp <?= number_format($row['gaji_pokok'], 0, ',', '.') ?>
                </td>
            </tr>
        </tbody>

    </table>

    <!-- RINGKASAN -->
    <div class="mt-4">

        <table class="table">

            <tr>
                <th width="70%">Bonus</th>

                <td class="text-success fw-bold">
                    Rp <?= number_format($row['bonus'], 0, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <th>Potongan</th>

                <td class="text-danger fw-bold">
                    Rp <?= number_format($row['potongan'], 0, ',', '.') ?>
                </td>
            </tr>

            <tr class="table-success">

                <th>Total Gaji</th>

                <td class="fw-bold fs-5">
                    Rp <?= number_format($row['total_gaji'], 0, ',', '.') ?>
                </td>

            </tr>

        </table>

    </div>

</div>

<?php } ?>

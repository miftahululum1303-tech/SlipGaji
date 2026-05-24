<div class="card card-premium p-4 rounded-4 mb-4">
    <h5 class="fw-bold mb-3"><i class="fa-solid fa-user-plus me-2"></i>Tambah Karyawan Baru</h5>
    <form action="pages/proses_tambah_karyawan.php" method="POST" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" id="nik_input" class="form-control" onkeyup="cariKaryawan()" placeholder="Masukkan NIK" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama" id="nama_karyawan" class="form-control" readonly placeholder="Nama Otomatis">
        </div>
        <div class="col-md-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan_karyawan" class="form-control" readonly placeholder="Jabatan Otomatis">
        </div>
        <div class="col-md-3">
            <label class="form-label">Golongan</label>
            <input type="text" name="golongan" id="golongan_karyawan" class="form-control" readonly placeholder="Golongan Otomatis">
        </div>
        <div class="col-12">
            <button type="submit" name="simpan" class="btn btn-success"><i class="fa-solid fa-save me-2"></i>Simpan Karyawan</button>
        </div>
    </form>
</div>

<div class="card card-premium p-4 rounded-4">
    <h5 class="fw-bold mb-3"><i class="fa-solid fa-users-gear me-2"></i>Transaksi Gaji - Berdasarkan Golongan</h5>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>NIK</th>
                <th>Nama Karyawan</th>
                <th>Golongan</th>
                <th>Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM transaksi_gaji");
            while($row = mysqli_fetch_array($sql)) { ?>
            <tr>
                <td><?= $row['nik']; ?></td>
                <td><?= $row['nama_karyawan']; ?></td>
                <td><?= $row['golongan']; ?></td>
                <td><?= $row['periode']; ?></td>
                <td><button class="btn btn-sm btn-info text-white">Detail</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="card card-premium p-4 rounded-4">
    <h5 class="fw-bold mb-3"><i class="fa-solid fa-users-gear me-2"></i>Transaksi Gaji - Berdasarkan Jabatan</h5>
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>NIK</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Periode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM transaksi_gaji");
            while($row = mysqli_fetch_array($sql)) { ?>
            <tr>
                <td><?= $row['nik']; ?></td>
                <td><?= $row['nama_karyawan']; ?></td>
                <td><?= $row['golongan']; ?></td>
                <td><?= $row['periode']; ?></td>
                <td><button class="btn btn-sm btn-info text-white">Detail</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
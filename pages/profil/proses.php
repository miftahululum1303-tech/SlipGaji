<?php

/* ========================================
   UPDATE PROFIL
======================================== */

if (isset($_POST['simpan_profil'])) {
    /* ========================================
       AMBIL SESSION
    ======================================== */

    $idUser = intval($_SESSION['id_user'] ?? 0);

    $idKaryawan = intval($_SESSION['id_karyawan'] ?? 0);

    /* ========================================
       VALIDASI SESSION
    ======================================== */

    if ($idUser <= 0 || $idKaryawan <= 0) {
        echo "

        <script>
            alert(
                'Session login tidak valid'
            );

            window.location =
                'auth/login.php';
        </script>

        ";

        exit();
    }

    /* ========================================
       AMBIL INPUT
    ======================================== */

    $nama = trim($_POST['nama_lengkap'] ?? '');

    $email = trim($_POST['email'] ?? '');

    /* ========================================
       VALIDASI INPUT
    ======================================== */

    if (empty($nama) || empty($email)) {
        echo "

        <script>
            alert(
                'Data profil tidak boleh kosong'
            );

            window.location =
                'index.php?page=profil';
        </script>

        ";

        exit();
    }

    /* ========================================
       SANITASI
    ======================================== */

    $nama = mysqli_real_escape_string(
        $koneksi,

        $nama,
    );

    $email = mysqli_real_escape_string(
        $koneksi,

        $email,
    );

    /* ========================================
       AMBIL FOTO LAMA
    ======================================== */

    $queryFoto = mysqli_query(
        $koneksi,

        "SELECT foto
         FROM karyawan
         WHERE id_karyawan='$idKaryawan'
         LIMIT 1",
    );

    $dataFoto = mysqli_fetch_assoc($queryFoto);

    $fotoLama = $dataFoto['foto'] ?? '';

    /* ========================================
       DEFAULT QUERY
    ======================================== */

    $updateFoto = '';

    /* ========================================
       CEK UPLOAD FOTO
    ======================================== */

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $namaFile = $_FILES['foto_profil']['name'];

        $tmpFile = $_FILES['foto_profil']['tmp_name'];

        $sizeFile = $_FILES['foto_profil']['size'];

        /* ========================================
           VALIDASI EXTENSION
        ======================================== */

        $extValid = ['jpg', 'jpeg', 'png'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if (!in_array($ext, $extValid)) {
            echo "

            <script>
                alert(
                    'Format foto harus JPG, JPEG, atau PNG'
                );

                window.location =
                    'index.php?page=profil';
            </script>

            ";

            exit();
        }

        /* ========================================
           VALIDASI SIZE
        ======================================== */

        if ($sizeFile > 2097152) {
            echo "

            <script>
                alert(
                    'Ukuran foto maksimal 2MB'
                );

                window.location =
                    'index.php?page=profil';
            </script>

            ";

            exit();
        }

        /* ========================================
           GENERATE FILE NAME
        ======================================== */

        $newFileName = 'avatar_' . time() . '_' . rand(1000, 9999) . '.' . $ext;

        $uploadPath = 'assets/uploads/' . $newFileName;

        /* ========================================
           UPLOAD FILE
        ======================================== */

        if (move_uploaded_file($tmpFile, $uploadPath)) {
            /* ========================================
               HAPUS FOTO LAMA
            ======================================== */

            if (!empty($fotoLama) && file_exists('assets/uploads/' . $fotoLama)) {
                unlink('assets/uploads/' . $fotoLama);
            }

            $updateFoto = ", foto='$newFileName'";
        }
    }

    /* ========================================
       UPDATE DATABASE
    ======================================== */

    $update = mysqli_query(
        $koneksi,

        "UPDATE karyawan

         SET

            nama_karyawan='$nama',
            email='$email'

            $updateFoto

         WHERE

            id_karyawan='$idKaryawan'",
    );

    /* ========================================
       BERHASIL
    ======================================== */

    if ($update) {
        echo "

        <script>
            alert(
                'Profil berhasil diperbarui'
            );

            window.location =
                'index.php?page=profil';
        </script>

        ";

        exit();
    }
    /* ========================================
       GAGAL
    ======================================== */ else {
        echo "

        <script>
            alert(
                'Gagal memperbarui profil'
            );

            window.location =
                'index.php?page=profil';
        </script>

        ";

        exit();
    }
}

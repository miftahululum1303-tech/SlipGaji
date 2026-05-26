-- =========================================
-- DATABASE
-- =========================================
CREATE DATABASE IF NOT EXISTS slipgaji;
USE slipgaji;


-- =========================================
-- TABLE USERS
-- =========================================
CREATE TABLE users (
id_user INT AUTO_INCREMENT PRIMARY KEY,
id_karyawan INT NULL,
username VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
role ENUM('admin','karyawan') NOT NULL DEFAULT 'karyawan',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- TABLE KARYAWAN
-- =========================================
CREATE TABLE karyawan (
id_karyawan INT AUTO_INCREMENT PRIMARY KEY,
nik VARCHAR(50) NOT NULL UNIQUE,
nama_karyawan VARCHAR(150) NOT NULL,
email VARCHAR(150) NULL,
no_hp VARCHAR(20) NULL,
alamat TEXT NULL,
jenis_kelamin ENUM('Laki-laki','Perempuan') NULL,
tanggal_masuk DATE NULL,
foto VARCHAR(255) NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- TABLE GOLONGAN
-- =========================================
CREATE TABLE golongan (
id_golongan INT AUTO_INCREMENT PRIMARY KEY,
nama_golongan VARCHAR(100) NOT NULL,
tunjangan_golongan BIGINT NOT NULL DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- TABLE JABATAN
-- =========================================
CREATE TABLE jabatan (
id_jabatan INT AUTO_INCREMENT PRIMARY KEY,
nama_jabatan VARCHAR(100) NOT NULL,
gaji_pokok BIGINT NOT NULL DEFAULT 0,
tunjangan_jabatan BIGINT NOT NULL DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================
-- TABLE TRANSAKSI GOLONGAN
-- =========================================
CREATE TABLE transaksi_golongan (
id_transaksi_golongan INT AUTO_INCREMENT PRIMARY KEY,
id_karyawan INT NOT NULL,
id_golongan INT NOT NULL,
tanggal_mulai DATE NOT NULL,

CONSTRAINT fk_tg_karyawan
FOREIGN KEY (id_karyawan)
REFERENCES karyawan(id_karyawan)
ON DELETE CASCADE,

CONSTRAINT fk_tg_golongan
FOREIGN KEY (id_golongan)
REFERENCES golongan(id_golongan)
ON DELETE CASCADE
);


-- =========================================
-- TABLE TRANSAKSI JABATAN
-- =========================================
CREATE TABLE transaksi_jabatan (
id_transaksi_jabatan INT AUTO_INCREMENT PRIMARY KEY,
id_karyawan INT NOT NULL,
id_jabatan INT NOT NULL,
tanggal_mulai DATE NOT NULL,

CONSTRAINT fk_tj_karyawan
FOREIGN KEY (id_karyawan)
REFERENCES karyawan(id_karyawan)
ON DELETE CASCADE,

CONSTRAINT fk_tj_jabatan
FOREIGN KEY (id_jabatan)
REFERENCES jabatan(id_jabatan)
ON DELETE CASCADE
);


-- =========================================
-- TABLE TRANSAKSI GAJI
-- =========================================
CREATE TABLE transaksi_gaji (
id_gaji INT AUTO_INCREMENT PRIMARY KEY,

id_karyawan INT NOT NULL,

periode VARCHAR(20) NOT NULL,

gaji_pokok BIGINT NOT NULL DEFAULT 0,
tunjangan_jabatan BIGINT NOT NULL DEFAULT 0,
tunjangan_golongan BIGINT NOT NULL DEFAULT 0,

bonus BIGINT NOT NULL DEFAULT 0,
potongan BIGINT NOT NULL DEFAULT 0,

total_gaji BIGINT NOT NULL DEFAULT 0,

tanggal_gaji DATETIME NOT NULL,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

CONSTRAINT fk_gaji_karyawan
FOREIGN KEY (id_karyawan)
REFERENCES karyawan(id_karyawan)
ON DELETE CASCADE
);


-- =========================================
-- RELASI USERS -> KARYAWAN
-- =========================================
ALTER TABLE users
ADD CONSTRAINT fk_users_karyawan
FOREIGN KEY (id_karyawan)
REFERENCES karyawan(id_karyawan)
ON DELETE SET NULL;


-- =========================================
-- DATA DEFAULT ADMIN
-- username : admin
-- password : admin123
-- =========================================
INSERT INTO users (
username,
password,
role
) VALUES (
'admin',
MD5('admin123'),
'admin'
);


-- =========================================
-- SAMPLE DATA KARYAWAN
-- =========================================
INSERT INTO karyawan (
nik,
nama_karyawan,
email,
no_hp,
alamat,
jenis_kelamin,
tanggal_masuk
) VALUES
(
'KRY001',
'Miftahul Ulum',
'miftah@example.com',
'081234567890',
'Malang',
'Laki-laki',
'2025-01-01'
),
(
'KRY002',
'Rafi Maulana',
'rafi@example.com',
'081298765432',
'Surabaya',
'Laki-laki',
'2025-01-10'
);


-- =========================================
-- SAMPLE USERS KARYAWAN
-- password : 12345
-- =========================================
INSERT INTO users (
id_karyawan,
username,
password,
role
) VALUES
(
1,
'miftah',
MD5('12345'),
'karyawan'
),
(
2,
'rafi',
MD5('12345'),
'karyawan'
);


-- =========================================
-- SAMPLE GOLONGAN
-- =========================================
INSERT INTO golongan (
nama_golongan,
tunjangan_golongan
) VALUES
(
'Golongan A',
500000
),
(
'Golongan B',
750000
),
(
'Golongan C',
1000000
);


-- =========================================
-- SAMPLE JABATAN
-- =========================================
INSERT INTO jabatan (
nama_jabatan,
gaji_pokok,
tunjangan_jabatan
) VALUES
(
'Staff IT',
4500000,
1000000
),
(
'Supervisor',
6500000,
2000000
),
(
'Manager',
9000000,
3500000
);


-- =========================================
-- SAMPLE TRANSAKSI GOLONGAN
-- =========================================
INSERT INTO transaksi_golongan (
id_karyawan,
id_golongan,
tanggal_mulai
) VALUES
(
1,
1,
'2025-01-01'
),
(
2,
2,
'2025-01-10'
);


-- =========================================
-- SAMPLE TRANSAKSI JABATAN
-- =========================================
INSERT INTO transaksi_jabatan (
id_karyawan,
id_jabatan,
tanggal_mulai
) VALUES
(
1,
1,
'2025-01-01'
),
(
2,
2,
'2025-01-10'
);


-- =========================================
-- SAMPLE TRANSAKSI GAJI
-- =========================================
INSERT INTO transaksi_gaji (
id_karyawan,
periode,
gaji_pokok,
tunjangan_jabatan,
tunjangan_golongan,
bonus,
potongan,
total_gaji,
tanggal_gaji
) VALUES
(
1,
'2025-05',
4500000,
1000000,
500000,
250000,
100000,
6150000,
NOW()
),
(
2,
'2025-05',
6500000,
2000000,
750000,
500000,
200000,
9550000,
NOW()
);

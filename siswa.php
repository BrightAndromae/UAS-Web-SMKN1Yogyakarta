<?php
include 'config.php';

session_start();

$session_login;
// periksa apakah sudah ada session login
if (isset($_SESSION['admin'])) {
    $session_login = "admin";
} else if (isset($_SESSION['siswa'])) {
    $session_login = "siswa";
} else if (isset($_SESSION['pegawai'])) {
    $session_login = "pegawai";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ambil data dari formulir
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tahunMasuk = $_POST['tahunMasuk'];
    $asalSekolah = $_POST['asalSekolah'];
    $date = date("Y-m-d H:i:s");
    $password = $_POST['password'];
    $encryptedPassword = md5($password);

    // buat query
    if ($_POST['isEdit'] == "no") {
        $sql = "INSERT INTO mst_siswa (nomor_induk_siswa, nama, alamat, tahun_masuk, asal_sekolah, created_date, updated_date, password) VALUE ('$nis', '$nama', '$alamat', '$tahunMasuk', '$asalSekolah', '$date', NULL, '$encryptedPassword')";
    } else {
        $sql = "UPDATE mst_siswa SET nama='$nama', alamat='$alamat', tahun_masuk='$tahunMasuk', asal_sekolah='$asalSekolah', updated_date='$date' WHERE nomor_induk_siswa=$nis";
    }

    $query = mysqli_query($conn, $sql);

    // apakah query simpan berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman sebelumnya dengan status=success
        $status = $_POST['isEdit'] == "yes" ? "successEdit" : "success";
        header('Location: daftar-siswa.php?status=' . $status);
    } else {
        // kalau gagal alihkan ke halaman sebelumnya dengan status=gagal
        $status = $_POST['isEdit'] == "yes" ? "failedEdit" : "failed";
        header('Location: daftar-siswa.php?status=failed');
    }
}

$nis = isset($_GET['nis']) ? $_GET['nis'] : false;

if ($nis) {
    // buat query untuk ambil data dari database
    $sql = "SELECT * FROM mst_siswa WHERE nomor_induk_siswa=$nis";
    $query = mysqli_query($conn, $sql);
    $siswa = mysqli_fetch_assoc($query);

    // jika data yang di-edit tidak ditemukan
    if (mysqli_num_rows($query) < 1) {
        die("data tidak ditemukan...");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 1 Yogyakarta</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #3498db;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
        }

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
        }

        .login-btn {
            background-color: #2ecc71;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .container {
            padding: 20px;
        }

        .footer {
            background-color: #34495e;
            color: white;
            padding: 10px;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        .school-info {
            font-size: 0.8em;
        }

        /* Add these styles to your existing CSS file */

        .container {
            padding: 20px;
        }

        .hero {
            text-align: center;
            margin-bottom: 30px;
        }

        .hero h1 {
            font-size: 2em;
        }

        .hero p {
            font-size: 1.2em;
            color: #555;
        }

        .hero img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }

        .about,
        .features {
            margin-bottom: 30px;
        }

        .about h2,
        .features h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .features ul {
            list-style: none;
            padding: 0;
        }

        .features li {
            margin-bottom: 8px;
        }

        /* Additional styles for the form */

        .form-section {
            background-color: #f8f8f8;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">SMKN 1 Yogyakarta</div>
        <ul class="nav-links">
            <li><a href="index.php">Halaman depan</a></li>
            <li><a href="daftar-siswa.php">Daftar Siswa</a></li>
            <li><a href="daftar-pegawai.php">Daftar Pegawai</a></li>
            <li><a href="daftar-kesan-pesan.php">Kesan dan Pesan</a></li>
        </ul>
        <div class="login-btn">
            <?php
            if (isset($session_login)) {
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?></div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <?php
        if (!$session_login == null) {
            if ($session_login == 'admin') {
                $nama = $_SESSION['admin'];
            } else {
                $data = $_SESSION[$session_login];
                $nama = $data['nama'];
            }
            echo '<h3>Halo, ' . $nama . '</h3>';
        }
        ?>
        <section class="form-section">
            <h2><?php echo isset($siswa) ? "Edit Siswa" : "Tambah siswa"; ?></h2>

            <form action="#" method="post" class="contact-form" style="margin-bottom:100px">
                <label for="nis">NIS:</label>
                <input type="number" id="nis" name="nis" value="<?php echo isset($siswa) ? $siswa['nomor_induk_siswa'] . '" readonly ' : ''; ?>" required>

                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo isset($siswa) ? $siswa['nama'] : ''; ?>" required>


                <label for="password" <?php echo isset($siswa) ? "hidden" : ''; ?>>Password:</label>
                <input type="password" id="password" name="password" value="<?php echo isset($siswa) ? $siswa['password'] : ''; ?>" required <?php echo isset($siswa) ? "hidden" : ''; ?>>

                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo isset($siswa) ? $siswa['alamat'] : ''; ?>" required>

                <label for="tahunMasuk">Tahun Masuk:</label>
                <input type="number" id="tahunMasuk" name="tahunMasuk" value="<?php echo isset($siswa) ? $siswa['tahun_masuk'] : ''; ?>" required>

                <label for="asalSekolah">Asal Sekolah:</label>
                <input type="text" id="asalSekolah" name="asalSekolah" value="<?php echo isset($siswa) ? $siswa['asal_sekolah'] : ''; ?>" required>

                <input type="text" id="isEdit" name="isEdit" value="<?php echo isset($siswa) ? "yes" : "no"; ?>" hidden>

                <button type="submit"><?php echo isset($siswa) ? "Edit Siswa" : "Tambah siswa"; ?></button>
            </form>
        </section>
    </div>
    <!-- Sticky Footer -->
    <footer class="footer">
        <div class="school-info">
            <p>SMKN 1 Yogyakarta</p>
            <p>jalan Kemetiran Kidul 35 Yogyakarta, alamat lama jalan Kemetiran Kidul 47 Yogyakarta</p>
        </div>
    </footer>

</body>

</html>
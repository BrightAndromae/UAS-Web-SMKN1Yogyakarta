<?php
include 'config.php';

session_start();

$session_login = null; // Inisialisasi variabel

// periksa apakah sudah ada session login
if (isset($_SESSION['admin'])) {
    $session_login = "admin";
} else if (isset($_SESSION['siswa'])) {
    $session_login = "siswa";
} else if (isset($_SESSION['pegawai'])) {
    $session_login = "pegawai";
}
?>
<?php
$data = $_SESSION[$session_login];
$nama = $data['nama'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ambil data dari formulir
    $pesanKesan = $_POST['pesanKesan'];
    $createdDate = date("Y-m-d H:i:s");

    // ambil data dari session
    $data = $_SESSION[$session_login];
    if ($session_login == 'siswa') {
        $nis = $data['nomor_induk_siswa'];

        // buat query
        $sql = "INSERT INTO trx_pesan_kesan (nomor_induk, is_siswa, pesan_kesan, created_date, updated_date) VALUE ('$nis', 1, '$pesanKesan', '$createdDate', NULL)";
    } else if ($session_login == 'pegawai') {
        $nip = $data['nomor_induk_pegawai'];

        // buat query
        $sql = "INSERT INTO trx_pesan_kesan (nomor_induk, is_siswa, pesan_kesan, created_date, updated_date) VALUE ('$nip', 0, '$pesanKesan', '$createdDate', NULL)";
    }


    $query = mysqli_query($conn, $sql);

    // apakah query simpan berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman sebelumnya dengan status=sukses
        header('Location: daftar-kesan-pesan.php?status=success');
    } else {
        // kalau gagal alihkan ke halaman sebelumnya dengan status=gagal
        header('Location: daftar-kesan-pesan.php?status=failed');
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
            <h2>Tambah pesan dan kesan</h2>

            <form class="contact-form" action="#" method="post" style="margin-bottom:100px">
                <label for="pesan_kesan">Pesan dan Kesan:</label>
                <textarea id="pesan_kesan" name="pesanKesan" required></textarea>

                <button type="submit">Tambah pesan dan kesan</button>
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
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
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $alamat = $_POST['alamat'];
    $pendidikanTerakhir = $_POST['pendidikanTerakhir'];
    $pengalamanMengajar = $_POST['pengalamanMengajar'];

    $date = date("Y-m-d H:i:s");


    // buat query

    if ($_POST['isEdit'] == "no") {
        $password = $_POST['password'];
        $encryptedPassword = md5($password);
        $sql = "INSERT INTO mst_pegawai (nomor_induk_pegawai, nama, jabatan, alamat, pendidikan_terakhir, pengalaman_mengajar, created_date, updated_date, password) VALUE ('$nip', '$nama', '$jabatan', '$alamat', '$pendidikanTerakhir', '$pengalamanMengajar', '$date', NULL, '$encryptedPassword')";
    } else {
        $sql = "UPDATE mst_pegawai SET nama='$nama', jabatan='$jabatan', alamat='$alamat', pendidikan_terakhir='$pendidikanTerakhir', pengalaman_mengajar='$pengalamanMengajar', updated_date='$date' WHERE nomor_induk_pegawai=$nip";
    }

    $query = mysqli_query($conn, $sql);

    // apakah query simpan berhasil?
    if ($query) {
        // kalau berhasil alihkan ke halaman sebelumnya dengan status=success
        $status = $_POST['isEdit'] == "yes" ? "successEdit" : "success";
        header('Location: daftar-pegawai.php?status=' . $status);
    } else {
        // kalau gagal alihkan ke halaman sebelumnya dengan status=gagal
        $status = $_POST['isEdit'] == "yes" ? "failedEdit" : "failed";
        header('Location: daftar-pegawai.php?status=' . $status);
    }
}

$nip = isset($_GET['nip']) ? $_GET['nip'] : false;

if ($nip) {
    // buat query untuk ambil data dari database
    $sql = "SELECT * FROM mst_pegawai WHERE nomor_induk_pegawai=$nip";
    $query = mysqli_query($conn, $sql);
    $pegawai = mysqli_fetch_assoc($query);

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
            <h2><?php echo isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai'; ?></h2>

            <form class="contact-form" action="#" method="post" style="margin-bottom:100px">
                <label for="nip">NIP:</label>
                <input type="number" id="nip" name="nip" value="<?php echo isset($pegawai) ? $pegawai['nomor_induk_pegawai'] . '" readonly ' : ''; ?>" required>

                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo isset($pegawai) ? $pegawai['nama'] : ''; ?>" required>

                <?php if (!isset($pegawai)) { ?>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                <?php } ?>

                <label for="jabatan">Jabatan:</label>
                <select id="jabatan" name="jabatan" required>
                    <option value="guru" <?php echo (isset($pegawai) && $pegawai['jabatan'] === 'guru') ? 'selected' : ''; ?>>Guru</option>
                    <option value="staf" <?php echo (isset($pegawai) && $pegawai['jabatan'] === 'staf') ? 'selected' : ''; ?>>Staf</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo isset($pegawai) ? $pegawai['alamat'] : ''; ?>" required>

                <label for="pendidikanTerakhir">Pendidikan Terakhir:</label>
                <input type="text" id="pendidikanTerakhir" name="pendidikanTerakhir" value="<?php echo isset($pegawai) ? $pegawai['pendidikan_terakhir'] : ''; ?>" required>

                <label for="pengalamanMengajar">Pengalaman Mengajar:</label>
                <input type="text" id="pengalamanMengajar" name="pengalamanMengajar" value="<?php echo isset($pegawai) ? $pegawai['pengalaman_mengajar'] : ''; ?>" required>

                <input type="hidden" id="isEdit" name="isEdit" value="<?php echo isset($pegawai) ? 'yes' : 'no'; ?>">

                <button type="submit"><?php echo isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai'; ?></button>
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
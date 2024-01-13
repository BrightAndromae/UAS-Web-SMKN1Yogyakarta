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
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">SMKN 1 Yogyakarta</div>
    <ul class="nav-links">
      <li><a href="index.php">Halaman depan</a></li>
      <?php
      if (isset($session_login)) {
      ?>
        <li><a href="daftar-siswa.php">Daftar Siswa</a></li>
        <li><a href="daftar-pegawai.php">Daftar Pegawai</a></li>
      <?php
      }
      ?>
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
    <section class="hero">
      <h1>Selamat Datang di SMKN 1 Yogyakarta</h1>
      <p>Memberikan pendidikan berkualitas untuk masa depan yang lebih cerah.</p>
      <img src="img/1.jpg" alt="Gambar Sekolah">
    </section>

    <section class="about">
      <h2>Sambutan kepala sekolah</h2>
      <p>Assalamualaikum Warahmatullahi Wabarokatuh</p>
      <p>Pujian, hormat, dan syukur kita panjatkan kepada Allah SWT karena berkat rahmat dan cinta-Nya</p>
      <p>Kemajuan Teknologi Informasi dan Komunikasi di era globalisasi dewasa ini telah membawa implikasi, termasuk di dunia pendidikan</p>
      <p>Pengembangan website ini disamping untuk memenuhi kebutuhan informasi, juga untuk memenuhi harapan publik yang membutuhkan informasi pendidikan yang diselenggaran oleh SMP</p>
      <p>E-Learning, E-Commerce, Electronic Education (teleconprence), E-Information, bahkan dalam melaksanakan rutinitas sehari-hari kita telah banyak dibantu dengan kehadiran teknologi</p>
    </section>

    <section class="about">
      <h2>Tentang Kami</h2>
      <p>SMK Negeri 1 Yogyakarta beralamat di jalan Kemetiran Kidul 35 Yogyakarta, alamat lama jalan Kemetiran Kidul 47 Yogyakarta, lebih dikenal dengan nama SMEA 2 Yogyakarta. SMK Negeri 1 Yogyakarta merupakan salah satu Sekolah Menengah yang cukup tua di Indonesia dan cukup punya nama di dunia industri maupun pemerintahan. Banyak lulusannya bekerja tersebar di berbagai bidang industri maupun pemerintahan di wilayah Indonesia.
        Gedungnya anggun dan berwibawa, dengan luas kurang lebih 3400 m2. Karena merupakan peninggalan sejarah yang dahulu adalah gedung Sekolah Dasar milik Thiongha yang bernama SD “Chung Hua Tsung Hui”, maka gedung ini oleh Menteri Kebudayaan dan Pariwisata melalui Peraturan Menteri Nomor: PM.25/PW.007/MKP/2007 ditetapkan sebagai cagar budaya.</p>
    </section>

    <section class="about">
      <h2>Sejarah Sekolah</h2>
      <p>SMPN 1 Jogjakarta telah menghadapi perubahan dan berkembang dalam era teknologi informasi dan komunikasi. Sejak itu, sekolah ini mencoba mengembangkan kebijakan pengembangan teknologi untuk menjaga relevansi dan meningkatkan kualitas pendidikan di sekolah
      </p>
    </section>

    <section class="features">
      <h2>Fasilitas Kami</h2>
      <ul>
        <li>Guru Berpengalaman</li>
        <img src="img/3.jpg" height="200" />
        <li>Fasilitas Modern</li>
        <img src="img/2.jpeg" height="200" />
        <li>Lingkungan Pembelajaran Interaktif</li>
        <img src="img/4.jpeg" height="200" />
      </ul>
    </section>

    <section class="features">
      <h2>Lokasi sekolah</h2>
      <iframe width="600" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=SMKN%201%20Jogjakarta%20Bogor+(SMKN%201%20Jogjakarta)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.acadoo.de/'>Masterarbeit schreiben lassen</a>
      <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=a1a68520c4389c76bdeaee1b7936e29a0857187a'></script>

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
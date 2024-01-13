<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = "admin123";
    $admin_password = "password";

    $input_nis = $_POST['nisornip'];
    $input_password = $_POST['password'];

    // cek username password
    if ($input_nis === $admin_id && $input_password === $admin_password) {
        $_SESSION['admin'] = $admin_id;
        header("Location: index.php");
        exit();
    } else {

        // cek jenis user sebagai siswa atau pegawai
        // encrypt input password
        $encryptedPassword = md5($input_password);

        // Search in mst_siswa table
        $sql_siswa = "SELECT * FROM mst_siswa WHERE nomor_induk_siswa='$input_nis' AND password = '$encryptedPassword'";
        $query_siswa = mysqli_query($conn, $sql_siswa);
        $siswa = mysqli_fetch_assoc($query_siswa);
        $siswa_count = mysqli_num_rows($query_siswa);

        // Search in mst_pegawai table if not found in mst_siswa
        if ($siswa_count > 0) {
            $_SESSION['siswa'] = $siswa;
            header("Location: index.php");
            exit();
        }

        // Search in mst_pegawai table
        $sql_pegawai = "SELECT * FROM mst_pegawai WHERE nomor_induk_pegawai='$input_nis' AND password = '$encryptedPassword'";
        $query_pegawai = mysqli_query($conn, $sql_pegawai);
        $pegawai = mysqli_fetch_assoc($query_pegawai);
        $pegawai_count = mysqli_num_rows($query_pegawai);

        // Check if credentials exist in mst_pegawai table
        if ($pegawai_count > 0) {
            $_SESSION['pegawai'] = $pegawai;
            header("Location: index.php");
            exit();
        } else {
            // Alert if credentials not found in both tables
            echo '<script language="javascript"> alert("Nomor induk atau password salah!");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMKN 1 Jogjakarta</title>
    <style>
        /* Reset some default styles */
        body,
        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <form action="#" class="login-form" method="POST">
            <h2>Login to SMKN 1 Jogjakarta</h2>
            <label for="nisornip">NIS/NIP:</label>
            <input type="text" id="nisornip" name="nisornip" placeholder="Enter your username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>
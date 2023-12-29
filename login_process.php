<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gantilah informasi ini sesuai dengan koneksi database Anda
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "uploadpdf";

    // Ambil data dari formulir login
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Buat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query untuk memeriksa apakah username dan password cocok
    $sql = "SELECT * FROM users WHERE username='$input_username' AND password='$input_password'";
    $result = $conn->query($sql);

    // Periksa hasil query
    if ($result->num_rows > 0) {
        // Login berhasil
        $_SESSION['username'] = $input_username;
        header("Location: filelist.php"); // Gantilah ini dengan halaman setelah login berhasil
    } else {
        // Login gagal
        header("Location: login.php?error=Invalid username or password");
    }

    $conn->close();
} else {
    // Jika bukan metode POST, alihkan kembali ke halaman login
    header("Location: login.php");
}
?>

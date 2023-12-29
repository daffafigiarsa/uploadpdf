<?php

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Logika logout
if (isset($_POST['logout'])) {
    // Hapus sesi dan alihkan ke halaman login
    session_destroy();
    header("Location: logout.php");
    exit();
}

// Koneksi ke database
$conn = mysqli_connect("localhost:3306", "root", "", "uploadpdf");

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari database
$queryuser = "SELECT code_emp, username FROM users";
$resultuser = mysqli_query($conn, $queryuser);

$querycomp = "SELECT id, short FROM company";
$resultcom = mysqli_query($conn, $querycomp);

// Cek apakah query berhasil
if (!$resultuser || !$resultcom) {
    die("Query gagal: " . mysqli_error($conn));
}

// Tutup koneksi database
mysqli_close($conn);

// Sertakan file storeiso.php
require 'navbar.php';
require 'storetype.php';

if (isset($_POST["submit"])) {
    // Cek apakah data berhasil ditambahkan atau tidak
    if (tambahtype($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'createiso.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan');
            document.location.href = 'createiso.php';
        </script>";
        mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Type</title>

    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Create Type</h2>

        <?php
        // // Tampilkan pesan kesalahan jika ada
        // if (isset($_SESSION['error'])) {
        //     echo '
        //     <div class="alert alert-danger alert-dismissible fade show" role="alert">
        //         ' . $_SESSION['error'] . '
        //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //     </div>';
        //     unset($_SESSION['error']);
        // }

        // // Tampilkan pesan sukses jika ada
        // if (isset($_SESSION['success'])) {
        //     foreach ($_SESSION['success'] as $successMessage) {
        //         echo '
        //         <div class="alert alert-success alert-dismissible fade show" role="alert">
        //             ' . $successMessage . '
        //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //         </div>';
        //     }
        //     unset($_SESSION['success']);
        // }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="description" class="form-label">Type Name:</label>
                <input type="text" name="description" class="form-control">
            </div>
            <div class="mb-3">
                <label for="short" class="form-label">Short Name:</label>
                <input type="text" name="short" class="form-control">
            </div>
            <div class="mb-3">
                <label for="dt_modified_date" class="form-label">Date</label>
                <input type="date" name="dt_modified_date" class="form-control">
            </div>

            <div class="mb-3">
                <label for="vc_created_user" class="form-label">User Create</label>
                <select id="vc_created_user" name="vc_created_user" class="form-select">
                    <?php
                    // Tampilkan data sebagai opsi dalam dropdown
                    while ($row = mysqli_fetch_assoc($resultuser)) {
                        echo '<option value="' . $row['code_emp'] . '">' . $row['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="comp_id" class="form-label">Company</label>
                <select id="comp_id" name="comp_id" class="form-select">
                    <?php
                    // Tampilkan data sebagai opsi dalam dropdown
                    while ($row = mysqli_fetch_assoc($resultcom)) {
                        echo '<option value="' . $row['id'] . '">' . $row['short'] . '</option>';
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn btn-primary" name="submit">Create</button>
            <!-- Tombol logout -->
        </form>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

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
$querydoc = "SELECT id, description FROM mst_document";
$resultdoc = mysqli_query($conn, $querydoc);

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
require 'navbar.php';
require 'upload.php';

// if (isset($_POST["submit"])) {
//     // Cek apakah data berhasil ditambahkan atau tidak
//     if (upload($_POST) > 0) {
//         echo "<script>
//             alert('Data berhasil ditambahkan');
//             document.location.href = 'createiso.php';
//         </script>";
//     } else {
//         echo "<script>
//             alert('Data gagal ditambahkan');
//             document.location.href = 'createiso.php';
//         </script>";
//         mysqli_error($conn);
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>

    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Upload PDF</h2>

        <?php
        // Tampilkan pesan kesalahan jika ada
        if (isset($_SESSION['error'])) {
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $_SESSION['error'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['error']);
        }

        // Tampilkan pesan sukses jika ada
        if (isset($_SESSION['success'])) {
            foreach ($_SESSION['success'] as $successMessage) {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $successMessage . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            unset($_SESSION['success']);
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
           
         <div class="mb-3">
                <label for="description" class="form-label">Doc Name</label>
                <select id="description" name="description" class="form-select">
                    <?php
                    // Tampilkan data sebagai opsi dalam dropdown
                    while ($row = mysqli_fetch_assoc($resultdoc)) {
                        echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                    }
                    ?>
                </select>
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

            <div class="mb-3">
                <label for="coverFile" class="form-label">Select Cover PDF:</label>
                <input type="file" name="coverFile" class="form-control" accept=".pdf" >
            </div>

            <div class="mb-3">
                <label for="historyFile" class="form-label">Select History PDF:</label>
                <input type="file" name="historyFile" class="form-control" accept=".pdf" >
            </div>

            <div class="mb-3">
                <label for="isiFile" class="form-label">Select Isi PDF:</label>
                <input type="file" name="isiFile" class="form-control" accept=".pdf" >
            </div>

            <div class="mb-3">
                <label for="attachmentFile" class="form-label">Select Attachment PDF:</label>
                <input type="file" name="attachmentFile" class="form-control" accept=".pdf" >
            </div>

            <div class="mb-3">
                <label for="recordFile" class="form-label">Select Record PDF:</label>
                <input type="file" name="recordFile" class="form-control" accept=".pdf" >
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Upload</button>
            <!-- Tombol logout -->
        </form>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






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
    header("Location: login.php");
    exit();
}

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

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="folderName" class="form-label">Folder Name:</label>
                <input type="text" name="folderName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="coverFile" class="form-label">Select Cover PDF:</label>
                <input type="file" name="coverFile" class="form-control" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="historyFile" class="form-label">Select History PDF:</label>
                <input type="file" name="historyFile" class="form-control" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="isiFile" class="form-label">Select Isi PDF:</label>
                <input type="file" name="isiFile" class="form-control" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="attachmentFile" class="form-label">Select Attachment PDF:</label>
                <input type="file" name="attachmentFile" class="form-control" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="recordFile" class="form-label">Select Record PDF:</label>
                <input type="file" name="recordFile" class="form-control" accept=".pdf" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
            <!-- Tombol logout -->
            <button type="submit" name="logout" class="btn btn-danger ml-2">Logout</button>
            <!-- Tombol berwarna hijau -->
            <a href="filelist.php" class="btn btn-success ml-2">Link Hijau</a>
        </form>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






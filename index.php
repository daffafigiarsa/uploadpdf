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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Doc PDF</title>

    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Create Doc PDF</h2>

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
                <label for="description" class="form-label">Name Doc</label>
                <input type="text" name="description" class="form-control" >
            </div>

            <div class="mb-3">
                <label for="doctype_id" class="form-label">Type</label>
                <input type="text" name="doctype_id" class="form-control" >
            </div>

            <div class="mb-3">
                <label for="iso_id" class="form-label">ISO Nn</label>
                <input type="text" name="iso_id" class="form-control" >
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

            <button type="submit" class="btn btn-primary">Upload</button>
            <!-- Tombol logout -->
            <button type="submit" name="logout" class="btn btn-danger ml-2">Logout</button>
            <!-- Tombol berwarna hijau -->
            <a href="filelist.php" class="btn btn-success ml-2">Link Hijau</a>
            <a href="createiso.php" class="btn btn-success ml-2">Buat ISO</a>
            <a href="createtype.php" class="btn btn-success ml-2">Buat Type</a>
        </form>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






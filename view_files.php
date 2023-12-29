<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter folder ada dalam URL
if (!isset($_GET['folder'])) {
    header("Location: index.php");
    exit();
}

$folderName = $_GET['folder'];
$folderPath = "uploads/" . $folderName;

// Periksa apakah folder yang diminta ada
if (!is_dir($folderPath)) {
    header("Location: index.php");
    exit();
}

// Membaca daftar file dan subfolder dalam folder
$files = scandir($folderPath);

// Koneksi ke database
$conn = mysqli_connect("localhost:3306", "root", "", "uploadpdf");

// Periksa koneksi database
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan data dari database
$query = "SELECT a.description, a.path, b.short FROM mst_document a, mst_doctype b WHERE a.comp_id = b.comp_id AND a.doctype_id = b.id";
$result = mysqli_query($conn, $query);

require 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Files - <?php echo $folderName; ?></title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">View Files - <?php echo $folderName; ?></h2>

        <?php
        // Menampilkan daftar file dan subfolder dalam tabel
        if ($files) {
            echo '<table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($files as $index => $item) {
                $itemPath = $folderPath . '/' . $item;

                // Hanya tampilkan file dan subfolder yang bukan direktori
                if ($item != "." && $item != "..") {
                    // Ambil data dari hasil query yang sesuai dengan nama dokumen
                    $row = mysqli_fetch_assoc($result);

                    echo '<tr>
                            <th scope="row">' . ($index + 1) . '</th>
                            <td>' . $item . '</td>
                            <td>' . $row['short'] . '</td>
                            <td>';

                    if (is_dir($itemPath)) {
                        // Jika itu adalah subfolder, tampilkan tombol untuk melihat isinya
                        echo '<a href="view_files.php?folder=' . $folderName . '/' . $item . '" class="btn btn-primary">View Files</a>';
                    } else {
                        // Jika itu adalah file, tampilkan tombol untuk melihat file
                        echo '<a href="view_file.php?folder=' . $folderName . '&file=' . $item . '" class="btn btn-primary">View File</a>';
                    }

                    echo '</td></tr>';
                }
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No files found.</p>';
        }

        // Tutup koneksi database
        mysqli_close($conn);
        ?>

        <!-- Tombol kembali ke halaman utama -->
        <a href="index.php" class="btn btn-primary">Back to Upload</a>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

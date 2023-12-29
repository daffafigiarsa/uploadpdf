<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter folder dan file ada dalam URL
if (!isset($_GET['folder']) || !isset($_GET['file'])) {
    header("Location: index.php");
    exit();
}

$folderName = $_GET['folder'];
$fileName = $_GET['file'];
$filePath = "uploads/$folderName/$fileName";

// Periksa apakah file atau folder yang diminta ada
if (!file_exists($filePath)) {
    header("Location: index.php");
    exit();
}
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File - <?php echo $fileName; ?></title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">View File - <?php echo $fileName; ?></h2>

        <?php
        // Menampilkan daftar file atau subfolder dalam tabel
        if (is_dir($filePath)) {
            // Jika itu adalah subfolder, tampilkan daftar file di dalamnya
            $files = scandir($filePath);
            
            if ($files) {
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';

                foreach ($files as $index => $item) {
                    $itemPath = $filePath . '/' . $item;

                    // Hanya tampilkan file dan subfolder yang bukan direktori
                    if ($item != "." && $item != "..") {
                        echo '<tr>
                                <th scope="row">' . ($index + 1) . '</th>
                                <td>' . $item . '</td>
                                <td>';

                        if (is_dir($itemPath)) {
                            // Jika itu adalah subfolder, tampilkan tombol untuk melihat isinya
                            echo '<a href="view_file.php?folder=' . $folderName . '/' . $fileName . '&file=' . $item . '" class="btn btn-primary">View Files</a>';
                        } else {
                            // Jika itu adalah file, tampilkan tombol untuk melihat file
                            echo '<a href="view_file.php?folder=' . $folderName . '/' . $fileName . '&file=' . $item . '" class="btn btn-primary">View File</a>';
                        }

                        echo '</td></tr>';
                    }
                }

                echo '</tbody></table>';
            } else {
                echo '<p>No files found.</p>';
            }
        } else {
            // Jika itu adalah file, tampilkan konten file
            echo '<object width="100%" height="700px" type="application/pdf" data="'.$filePath.'#toolbar=0" id="pdf_content">
            <p>Document load was not successful.</p>
             </object>';
        }
        ?>

        <!-- Tombol kembali ke halaman utama -->
        <a href="view_files.php?folder=<?php echo $folderName; ?>" class="btn btn-primary">Back to Files</a>
    </div>

    <!-- Tambahkan script Bootstrap JS (Opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function blockPrintShortcut(e) {
        // Mendeteksi tombol pintasan cetak (Ctrl + P di Windows/Linux, Command + P di Mac)
        if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P')) {
            // Mencegah aksi default (pencetakan)
            e.preventDefault();
            // Menampilkan pesan peringatan
            alert('Printing is disabled');
            return false;
        }
    }
    
    document.getElementById('pdf_content').addEventListener('keydown', blockPrintShortcut);
    // Mendeteksi peristiwa tombol pintasan cetak
    window.addEventListener('keydown', function (e) {
        // Mendeteksi tombol pintasan cetak (Ctrl + P di Windows/Linux, Command + P di Mac)
        if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P')) {
            // Mencegah aksi default (pencetakan)
            e.preventDefault();
            // Menampilkan pesan peringatan
            alert('Printing is disabled');
            return false;
        }
    });
</script>
</body>
</html>

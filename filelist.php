<?php
// Koneksi ke database
$conn = mysqli_connect("localhost:3306", "root", "", "uploadpdf");

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari database
$queryuser = "SELECT description, path FROM `mst_iso`";
$resultuser = mysqli_query($conn, $queryuser);

// Cek apakah query berhasil
if (!$resultuser) {
    die("Query gagal: " . mysqli_error($conn));
}

// Tutup koneksi database
mysqli_close($conn);
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">ISO Name</h2>

        <?php
        $folderPath = "uploads/";

        // Read the list of subfolders in the "uploads" folder
        $folders = glob($folderPath . "*", GLOB_ONLYDIR);

        // Display the list of folders in a table
        if ($folders) {
           
                echo '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Doc Name</th>
                        <th scope="col">View Files</th>
                    </tr>
                </thead>
                <tbody>';

                $index = 0; // Definisikan $index di sini
                while ($row = mysqli_fetch_assoc($resultuser)) {
                // Extract the folder name from the path

                echo '<tr>
                    <th scope="row">' . ($index + 1) . '</th>
                    <td>' . $row['description'] . '</td> 
                    <td><a href="view_files.php?folder=' . $row['path'] . '" class="btn btn-primary">View Files</a></td>
                </tr>';

                $index++;
                }

                echo '</tbody></table>';
        } else {
            echo '<p>No folders found.</p>';
        }
        ?>

    </div>

    
    <!-- Add Bootstrap JS script (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

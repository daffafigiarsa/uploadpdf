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
        <h2 class="mb-4">Doc Name</h2>

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
                            <th scope="col">Folder Name</th>
                            <th scope="col">View Files</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($folders as $index => $folder) {
                // Extract the folder name from the path
                $folderName = basename($folder);

                echo '<tr>
                        <th scope="row">' . ($index + 1) . '</th>
                        <td>' . $folderName . '</td>
                        <td><a href="view_files.php?folder=' . urlencode($folderName) . '" class="btn btn-primary">View Files</a></td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No folders found.</p>';
        }
        ?>
        <a href="logout.php" class="btn btn-danger ml-2">logout</a>

    </div>

    
    <!-- Add Bootstrap JS script (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

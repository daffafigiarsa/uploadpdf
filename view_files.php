<?php
// view_files.php

$folderPath = "uploads/";

if (isset($_GET['folder'])) {
    $folderName = $_GET['folder'];
    $folderPath .= $folderName . "/";

    $files = scandir($folderPath);

    if ($files) {
        echo '<h2 class="mb-4">Files in ' . $folderName . '</h2>';
        echo '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">File Name</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($files as $index => $file) {
            if (is_file($folderPath . $file)) {
                echo '<tr>
                        <th scope="row">' . ($index + 1) . '</th>
                        <td>' . $file . '</td>
                    </tr>';
            }
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No files found in ' . $folderName . '.</p>';
    }
} else {
    echo '<p>Invalid request. Please provide a folder name.</p>';
}
?>

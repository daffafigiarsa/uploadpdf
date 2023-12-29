<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost:3306", "root", "", "uploadpdf");

    function query($query)
    {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    // Ambil data dari formulir
    $folderName = $_POST["description"];

    $queryupload = "SELECT path FROM mst_document WHERE id = '$folderName'";
    $resultupload = mysqli_query($conn, $queryupload);

    $row = mysqli_fetch_assoc($resultupload);
    $pathupload = $row['path'];
    
    var_dump($pathupload);
    // Definisi nama-nama file yang diharapkan
    $expectedFiles = ['cover', 'history', 'isi', 'attachment', 'record'];

    // Validasi ekstensi dan nama file
    $success = true; // Menandakan apakah semua file berhasil diunggah
    $successMessages = [];

    foreach ($expectedFiles as $expectedFile) {
        $pdfFile = $_FILES[$expectedFile . "File"];

        // Membuat nama file acak
        $randomFileName = bin2hex(random_bytes(8));

        // Validasi ekstensi file
        $allowedExtensions = ['pdf'];
        $fileExtension = pathinfo($pdfFile['name'], PATHINFO_EXTENSION);

        if (!in_array($fileExtension, $allowedExtensions)) {
            $success = false;
            $_SESSION['error'] = "Ekstensi file $expectedFile tidak diizinkan. Silakan unggah file PDF.";
        } else {
            // Buat folder jika belum ada
            $folderPath = "uploads/$pathupload/$expectedFile";
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // Pindahkan file PDF ke folder dengan nama acak
            $pdfFilePath = $folderPath . "/" . $randomFileName . ".pdf";
            move_uploaded_file($pdfFile["tmp_name"], $pdfFilePath);

            $successMessages[] = "File $expectedFile berhasil diunggah ke folder: $folderPath";
        }
    }

    if ($success) {
        $_SESSION['success'] = $successMessages;
        header("Location: index.php");
        exit();
    }

}
?>

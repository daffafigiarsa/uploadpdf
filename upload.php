<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $folderName = $_POST["folderName"];
    
    // Definisi nama-nama file yang diharapkan
    $expectedFiles = ['cover', 'history', 'isi', 'attachment', 'record'];

    // Validasi ekstensi dan nama file
    $success = true; // Menandakan apakah semua file berhasil diunggah
    $successMessages = [];

    foreach ($expectedFiles as $expectedFile) {
        $pdfFile = $_FILES[$expectedFile . "File"];
        
        // Validasi ekstensi file
        $allowedExtensions = ['pdf'];
        $fileExtension = pathinfo($pdfFile['name'], PATHINFO_EXTENSION);

        if (!in_array($fileExtension, $allowedExtensions)) {
            $success = false;
            $_SESSION['error'] = "Ekstensi file $expectedFile tidak diizinkan. Silakan unggah file PDF.";
        } else {
            // Buat folder jika belum ada
            $folderPath = "uploads/$folderName/$expectedFile";
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Pindahkan file PDF ke folder
            $pdfFilePath = $folderPath . "/" . $pdfFile["name"];
            move_uploaded_file($pdfFile["tmp_name"], $pdfFilePath);

            $successMessages[] = "File $expectedFile berhasil diunggah ke folder: $folderPath";
        }
    }

    if ($success) {
        $_SESSION['success'] = $successMessages;
        // Redirect kembali ke halaman awal setelah berhasil mengunggah test
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Metode request tidak valid.";
    header("Location: index.php");
    exit();
}
?>

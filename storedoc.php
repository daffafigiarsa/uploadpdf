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
    $folderdoc = $_POST["description"];
    $folderISO = $_POST["iso_id"];

    $queryiso = "SELECT path FROM mst_iso WHERE id = $folderISO";
    $resultiso = mysqli_query($conn, $queryiso);

    // Ambil hasil query sebagai array asosiatif
    $row = mysqli_fetch_assoc($resultiso);
    $descriptionISO = $row['path'];

    // Mengganti karakter non-alphanumeric menjadi underscore di $folderdoc
    $folderdoc = preg_replace('/[^a-zA-Z0-9]/', '_', $_POST["description"]);

    // Menentukan path folder
    $folderPath = "uploads/$descriptionISO/$folderdoc";

    // Menentukan path uploadsFolder
    $uploadsFolder = "uploads/";

    // Mengambil bagian setelah "uploads/"
    $folderName = str_replace($uploadsFolder, '', $folderPath);

    // Validasi ekstensi dan nama file
    $success = true; // Menandakan apakah semua file berhasil diunggah
    $successMessages = [];

    // Menggunakan DIRECTORY_SEPARATOR untuk membuat path sesuai dengan sistem operasi
    if (!file_exists($folderPath)) {
        if (mkdir($folderPath, 0755, true)) {
            $successMessages[] = "Folder '$folderdoc' berhasil dibuat di '$folderPath'";
            echo '<script>alert("Folder ' . $folderdoc . ' berhasil dibuat di ' . $folderPath . '");</script>';
        } else {
            $success = false;
            $errorMessage = "Gagal membuat folder. ";
            $errorMessage .= "Error: " . error_get_last()['message'];
            $errorMessages[] = $errorMessage;
            echo '<script>alert("' . $errorMessage . '");</script>';
            return false;
        }
    }
    
    function tambahdoc($data)
    {
        global $conn; 
        global $folderName;

        // ... (Bagian kode lainnya)
        $description = $data["description"];
        $doctype_id = $data["doctype_id"];
        $iso_id = $data["iso_id"];
        $dt_modified_date = $data["dt_modified_date"];
        $vc_created_user = $data["vc_created_user"];
        $comp_id = $data["comp_id"];
        $dt_created_date = $dt_modified_date;
        $vc_modified_user = $vc_created_user;
        $path = $folderName;

        // Menggunakan $folderPath dalam query
        $query = "INSERT INTO mst_document VALUES ('','$description','$doctype_id','$iso_id','$dt_created_date','$vc_created_user','$dt_modified_date','$vc_modified_user','$comp_id','$path')";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    // ... (Bagian kode lainnya)
}
?>

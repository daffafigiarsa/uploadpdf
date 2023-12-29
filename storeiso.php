<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $folderISO = $_POST["description"];
    $folderPath = "uploads/" . preg_replace('/[^a-zA-Z0-9]/', '_', $folderISO);

    $uploadsFolder = "uploads/";

    // Mengambil bagian setelah "uploads/"
    $folderName = str_replace($uploadsFolder, '', $folderPath);

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

 // Validasi ekstensi dan nama file
 $success = true; // Menandakan apakah semua file berhasil diunggah
 $successMessages = [];

 if (!file_exists($folderPath)) {
    if (mkdir($folderPath, 0755, true)) {
        $successMessages[] = "Folder '$folderISO' berhasil dibuat di '$folderPath'";
    } else {
        $success = false;
        $errorMessages[] = "Gagal membuat folder nama folder tidak sesuai format folder: " . error_get_last()['message'];
        return false;
    }
}




function tambahiso($data)
{
    global $conn;

    global $folderName;


    $description = $data["description"];
    $dt_modified_date = $data["dt_modified_date"];
    $vc_created_user = $data["vc_created_user"];
    $comp_id = $data["comp_id"];
    $dt_created_date = $dt_modified_date;
    $vc_modified_user = $vc_created_user;
    $path = $folderName;


    $query = "INSERT INTO mst_iso VALUES ('','$description','$dt_created_date','$vc_created_user','$dt_modified_date','$vc_modified_user','$comp_id','$path')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}



}
?>
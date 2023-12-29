<?php

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

function tambahtype($data)
{
    global $conn;
    
    $description = $data["description"];
    $short = $data["short"];
    $dt_modified_date = $data["dt_modified_date"];
    $vc_created_user = $data["vc_created_user"];
    $comp_id = $data["comp_id"];
    $dt_created_date = $dt_modified_date;
    $vc_modified_user = $vc_created_user;
 


    $query = "INSERT INTO mst_doctype VALUES ('','$description',' $short','$dt_created_date','$vc_created_user','$dt_modified_date','$vc_modified_user','$comp_id')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
?>
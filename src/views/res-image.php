<?php
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the uploaded file
    $extension = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
    $dst_fname = getcwd() . '/uploads/' . time() . uniqid(rand()) . '.' . $extension;
    $dst_fname = str_replace('\\', '/', $dst_fname);
    move_uploaded_file($_FILES["img"]["tmp_name"], $dst_fname);

    // Prepare data to send to Flask
    $url = "http://127.0.0.1:5000/test";
    $ch = curl_init($url);
    $data = array('input_data' => new CURLFile($dst_fname));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check the response
    $resultObj = json_decode($response);

    if ($resultObj) {
        // Check if face is found and display the result
        if (isset($resultObj->found) && $resultObj->found == "yes") {
            $resImage = $resultObj->image;
            $query = "SELECT * FROM `report` WHERE `photo` = '" . basename($resImage) . "'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);

            // Display the result if a match is found
            if ($row) {
                echo json_encode([
                    "found" => "yes",
                    "image" => $row['photo'],
                    "sim" => $resultObj->sim,
                    "id" => $row['id']
                ]);
            } else {
                echo json_encode(["found" => "no"]);
            }
        } else {
            echo json_encode(["found" => "error"]);
        }
    } else {
        echo json_encode(["found" => "error"]);
    }
}
?>
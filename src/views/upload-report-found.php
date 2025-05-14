<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["id"])) {
    header("location: found-person.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("config/database.php");

    $photo = $_FILES["photo"];
    $photo_name = time() . basename($photo['name']);
    $photo_tmp_name = $photo['tmp_name'];
    $allowed_files = ['png', 'jpg', 'jpeg'];
    $extension = pathinfo($photo_name, PATHINFO_EXTENSION);

    if ($photo['error'] != UPLOAD_ERR_OK) {
        $_SESSION["report-errors"] = "Enter the person found photo";
    } elseif (!in_array($extension, $allowed_files)) {
        $_SESSION["report-errors"] = "File should be png, jpg, or jpeg";
    } elseif (empty($_POST["child-name"])) {
        $_SESSION["report-errors"] = "Enter the person found name";
    } elseif (empty($_POST["age"]) || $_POST["age"] >= 200) {
        $_SESSION["report-errors"] = "Enter the person found age";
    } elseif (empty($_POST["gender"])) {
        $_SESSION["report-errors"] = "Enter the person found gender";
    } elseif (empty($_POST["health"])) {
        $_SESSION["report-errors"] = "Enter the person found health state";
    } elseif (empty($_POST["date"])) {
        $_SESSION["report-errors"] = "Enter the person found date";
    } elseif (empty($_POST["child-city"])) {
        $_SESSION["report-errors"] = "Enter the person found city";
    } elseif (empty($_POST["reporter-name"])) {
        $_SESSION["report-errors"] = "Enter your name";
    } elseif (strlen($_POST["phone"]) != 11) {
        $_SESSION["report-errors"] = "Enter your phone number";
    } elseif (empty($_POST["reporter-city"])) {
        $_SESSION["report-errors"] = "Enter city where you live";
    }

    if (isset($_SESSION["report-errors"])) {
        $_SESSION['report-data'] = $_POST;
        header("location: found-person.php");
        exit;
    }

    $destination = "uploads/" . $photo_name;
    if (!move_uploaded_file($photo_tmp_name, $destination)) {
        $_SESSION["report-errors"] = "Failed to upload the photo.";
        header("location: found-person.php");
        exit;
    }

    $child_name = mysqli_real_escape_string($connection, $_POST["child-name"]);
    $age = mysqli_real_escape_string($connection, $_POST["age"]);
    $gender = mysqli_real_escape_string($connection, $_POST["gender"]);
    $health = mysqli_real_escape_string($connection, $_POST["health"]);
    $date = mysqli_real_escape_string($connection, $_POST["date"]);
    $child_city = mysqli_real_escape_string($connection, $_POST["child-city"]);
    $reporter_name = mysqli_real_escape_string($connection, $_POST["reporter-name"]);
    $relevance = "none"; // Set to "none" for found persons
    $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
    $reporter_city = mysqli_real_escape_string($connection, $_POST["reporter-city"]);
    $type = "found";

    $query = "INSERT INTO report (photo, `child-name`, age, gender, health, `date`, `child-city`, `reporter-name`, relevance, phone, `reporter-city`, type, user_id) VALUES ('$photo_name', '$child_name', '$age', '$gender', '$health', '$date', '$child_city', '$reporter_name', '$relevance', '$phone', '$reporter_city', '$type', '{$_SESSION['id']}')";

    if (mysqli_query($connection, $query)) {
        $_SESSION['report-success'] = "The report has been uploaded successfully.";
        header("location: found-person.php");
        exit;
    } else {
        echo "Database error: " . mysqli_error($connection);
    }
    mysqli_close($connection);
}
?>
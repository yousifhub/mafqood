<?php
session_start();
if (isset($_SESSION["id"])) {
    $error_info = array();
    $info = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //validation
        if (!(isset($_POST['fname']) && !empty($_POST['fname']))) {
            $error_info[] = "fname";
        }
        if (!(isset($_POST['lname']) && !empty($_POST['lname']))) {
            $error_info[] = "lname";
        }
        if (!(isset($_POST['email']) && filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
            $error_info[] = "email";
        }
        if ($error_info) {
            header("location: profile.php?error_info=" . implode(",", $error_info));
            exit;
        }

        // if (!$error_info) {
        require("config/database.php");
        $fname = mysqli_escape_string($connection, $_POST["fname"]);
        $lname = mysqli_escape_string($connection, $_POST["lname"]);
        $email = mysqli_escape_string($connection, $_POST["email"]);
        $query = "UPDATE `users` SET `fname` = '" . $fname . "', `lname` = '" . $lname . "', `email` = '" . $email . "' WHERE `users`.`id` = " . $_SESSION["id"];
        if (mysqli_query($connection, $query)) {
            $_SESSION["email"] = $email;
            $_SESSION["fname"] = $fname;
            $info[] = "success";
            header("location: profile.php?info=" . implode(",", $info));
            exit;
        } else {
            echo mysqli_error($connection);
        }
        mysqli_close($connection);
        // }
    }
} else {
    header("location: login.php");
}

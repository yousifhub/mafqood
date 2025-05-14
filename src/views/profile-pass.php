<?php
session_start();
if (isset($_SESSION["id"])) {
    $error_pass = array();
    $password = array();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //validation
        if (!(isset($_POST['old_pass']) && strlen($_POST['old_pass']) > 5)) {
            $error_pass[] = "old";
        }
        if (!(isset($_POST['pass']) && strlen($_POST['pass']) > 5)) {
            $error_pass[] = "pass";
        }
        if ($_POST["pass"] !== $_POST["confirm_pass"]) {
            $error_pass[] = "confirm_pass";
        }
        if ($error_pass) {
            header("location: profile.php?error_pass=" . implode(",", $error_pass));
            exit;
        }

        // if (!$error_pass) {
        require("config/database.php");
        $old_pass = sha1($_POST["old_pass"]);
        $pass = sha1($_POST["pass"]);
        $check_old = "SELECT `pass` FROM `users` WHERE `users`.`id` = " . $_SESSION["id"];
        $result = mysqli_query($connection, $check_old);
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row["pass"] == $old_pass) {
                $query = "UPDATE `users` SET `pass` = '" . $pass . "' WHERE `users`.`id` = " . $_SESSION["id"];
                if (mysqli_query($connection, $query)) {
                    $password[] = "success";
                    header("location: profile.php?password=" . implode(",", $password));
                    exit;
                } else {
                    echo mysqli_error($connection);
                }
            } else {
                $error_pass[] = "notequal";
                header("location: profile.php?error_pass=" . implode(",", $error_pass));
                exit;
            }
        }
        mysqli_free_result($result);
        mysqli_close($connection);
        // }
    }
} else {
    header("location: login.php");
}

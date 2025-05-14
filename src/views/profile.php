<?php
$error_info = array();
$error_pass = array();
$info = array();
$password = array();
if (isset($_GET["error_info"])) {
    $error_info = explode(",", $_GET["error_info"]);
}
if (isset($_GET["error_pass"])) {
    $error_pass = explode(",", $_GET["error_pass"]);
}
if (isset($_GET["info"])) {
    $info = explode(",", $_GET["info"]);
}
if (isset($_GET["password"])) {
    $password = explode(",", $_GET["password"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/profile.css" />
    <!-- <link rel="stylesheet" href="css/all-people.css" /> -->
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Profile</title>
</head>

<body>
    <?php include "partials/header.php" ?>
    <?php
    if (!isset($_SESSION["id"])) {
        header("location: login.php");
    }
    // require("config/database.php");
    $query = "SELECT * FROM `users` WHERE `id` =" . $_SESSION["id"];
    $result = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $fname = $row["fname"];
        $lname = $row["lname"];
        $email = $row["email"];
    }
    ?>
    <div class="found-text">
        <h1>Manage my profile</h1>
    </div>
    <div class="profile">
        <div class="prosses-con">
            <div class="info">
                <?php if (in_array("success", $info)) echo "<p class='error'>Data has been updated successfully</p>" ?>
                <form action="profile-info.php" method="post">
                    <div class="name field">
                        <div class="box">
                            <input type="text" name="fname" id="" placeholder="First name" value="<?= (in_array("fname", $error_info)) ? "" : $fname ?>" />
                            <?php if (in_array("fname", $error_info)) echo "<p class='error-top'>Enter first name</p>" ?>
                        </div>
                        <div class="box">
                            <input type="text" name="lname" id="" placeholder="Last name" value="<?= (in_array("lname", $error_info)) ? "" : $lname ?>" />
                            <?php if (in_array("lname", $error_info)) echo "<p class='error-top'>Enter last name</p>" ?>
                        </div>
                    </div>
                    <div class="email field">
                        <input type="text" name="email" id="" placeholder="Enter new email" value="<?= (in_array("email", $error_info)) ? "" : $email ?>" />
                        <?php if (in_array("email", $error_info)) echo "<p class='error-top'>Enter correct email</p>" ?>
                    </div>
                    <input type="submit" value="update">
                </form>
            </div>
            <div class="password">
                <?php if (in_array("success", $password)) echo "<p class='error'>Password has been changed successfully</p>" ?>
                <?php if (in_array("notequal", $error_pass)) echo "<p class='error'>Old password incorrect</p>" ?>
                <form action="profile-pass.php" method="post">
                    <div class="pass old">
                        <input type="password" name="old_pass" id="" placeholder="Enter old pass">
                        <?php if (in_array("old", $error_pass)) echo "<p class='error-top'>Enter pass more than 5 char</p>" ?>
                    </div>
                    <div class="pass new">
                        <div class="box">
                            <input type="password" name="pass" id="" placeholder="New password">
                            <?php if (in_array("pass", $error_pass)) echo "<p class='error-top'>Enter pass more than 5 char</p>" ?>
                        </div>
                        <div class="box">
                            <input type="password" name="confirm_pass" id="" placeholder="Confirm new password">
                            <?php if (in_array("confirm_pass", $error_pass)) echo "<p class='error-top'>Not the same</p>" ?>
                        </div>
                    </div>
                    <input type="submit" value="change">
                </form>
            </div>
        </div>
    </div>
    <script src="js/header.js"></script>
</body>

</html>
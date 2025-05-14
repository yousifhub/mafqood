<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Contact Us</title>
</head>

<body>
    <?php
    include "partials/header.php";
    $error_fields = array();
    $success = array();
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // check errors
        $phone_number_digits = preg_replace("/[^0-9]/", "", $_POST["phone"]);
        if (!(isset($_POST['name']) && !empty($_POST['name']))) {
            $error_fields[] = "name";
        } elseif (!strlen($phone_number_digits) == 11) {
            $error_fields[] = "phone";
        } elseif (!(isset($_POST['email']) && filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
            $error_fields[] = "email";
        } elseif (!(isset($_POST['subject']) && !empty($_POST['subject']))) {
            $error_fields[] = "subject";
        } elseif (!(isset($_POST['message']) && !empty($_POST['message']))) {
            $error_fields[] = "message";
        }

        if (empty($error_fields)) {
            $name = mysqli_escape_string($connection, $_POST["name"]);
            $phone = mysqli_escape_string($connection, $_POST["phone"]);
            $email = mysqli_escape_string($connection, $_POST["email"]);
            $subject = mysqli_escape_string($connection, $_POST["subject"]);
            $message = mysqli_escape_string($connection, $_POST["message"]);
            $query = "INSERT into contact (name,phone,email,subject,message) VALUES 
            ('" . $name . "','" . $phone . "','" . $email . "','" . $subject . "','" . $message . "')";
            if (mysqli_query($connection, $query)) {
                $success[] = "success";
            }
        }
    }
    ?>
    <div class="contact">
        <div class="overlay"></div>
        <h2 class="main-head">Contact Us</h2>
        <div class="container">
            <?php
            if (in_array("success", $success)) {
                echo "<p class='cont-success'>You have sent your message successfully</p>";
            }
            if (in_array("name", $error_fields)) {
                echo "<p class='cont-error'>Enter your name</p>";
            }
            if (in_array("phone", $error_fields)) {
                echo "<p class='cont-error'>Enter invalid phone number</p>";
            }
            if (in_array("email", $error_fields)) {
                echo "<p class='cont-error'>Enter invalid email</p>";
            }
            if (in_array("subject", $error_fields)) {
                echo "<p class='cont-error'>Enter subject of email</p>";
            }
            if (in_array("message", $error_fields)) {
                echo "<p class='cont-error'>Enter your message</p>";
            }
            ?>
            <form action="" method="post">
                <div>
                    <input type="text" name="name" placeholder="Your Name" />
                    <input type="text" name="phone" maxlength="11" placeholder="Your Number" />
                    <input type="email" name="email" placeholder="Your Email" />
                    <input type="text" name="subject" placeholder="Your Subject" />
                </div>
                <div>
                    <textarea placeholder="Your Message" name="message"></textarea>
                    <input type="submit" value="send" />
                </div>
            </form>
        </div>
    </div>
    <?php include("partials/footer.php") ?>
    <script src="js/header.js"></script>
</body>

</html>
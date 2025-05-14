<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["id"])) {
    header("Location: index.php");
}

$error = array();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['pass'])) {
            // Set session variables
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'fname' => $user['fname'],
                'is_admin' => $user['is_admin']
            ];

            // Redirect based on user role
            if ($user['is_admin'] == 1) {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            echo "كلمة المرور غير صحيحة";
        }
    } else {
        echo "المستخدم غير موجود";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

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
    <title>تسجيل الدخول</title>
</head>

<body>
    <div class="login-content">
        <div class="login">
            <span>مفــــقــــود</span>
            <h1>تسجيل الدخول</h1>
            <form method="post">
                <?php
                if (in_array("not_exist", $error)) {
                    echo "<p class='error'>البريد الإلكتروني أو كلمة المرور غير صحيحة</p>";
                }
                if (in_array("banned", $error)) {
                    echo "<p class='error'>تم حظر هذا الحساب</p>";
                }
                ?>
                <div class="cont">
                    <input type="email" name="email" id="" placeholder="أدخل بريدك الإلكتروني" value="<?= isset($_POST["email"]) ? $_POST["email"] : "" ?>" />
                    <?php if (in_array("email", $error)) {
                        echo "<p class='error-top'>أدخل بريد إلكتروني صحيح</p>";
                    } ?>
                </div>
                <div class="cont">
                    <input type="password" name="password" id="" placeholder="أدخل كلمة المرور" />
                    <?php if (in_array("pass", $error)) {
                        echo "<p class='error-top'>كلمة المرور يجب أن تكون أكثر من 5 أحرف</p>";
                    } ?>
                </div>
                <input type="submit" value="تسجيل الدخول" />
            </form>
            <div class="other">
                <a href="signup">ليس لديك حساب؟</a>
                <a href="#">نسيت كلمة المرور؟</a>
            </div>
        </div>
    </div>
</body>

</html>
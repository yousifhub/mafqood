<?php
require __DIR__ . '/../partials/header.php';
$error_fields = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation
    if (!(isset($_POST['fname']) && !empty(trim($_POST['fname'])))) {
        $error_fields[] = "fname";
    }
    if (!(isset($_POST['lname']) && !empty(trim($_POST['lname'])))) {
        $error_fields[] = "lname";
    }
    if (!(isset($_POST['email']) && filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
        $error_fields[] = "email";
    }
    if (!(isset($_POST['pass']) && strlen($_POST['pass']) > 5)) {
        $error_fields[] = "pass";
    }
    if ($_POST["pass"] !== $_POST["passConfirm"]) {
        $error_fields[] = "passConfirm";
    }

    if (!$error_fields) {
        require __DIR__ . '/../config/database.php';
        $fname = mysqli_real_escape_string($connection, trim($_POST["fname"]));
        $lname = mysqli_real_escape_string($connection, trim($_POST["lname"]));
        $email = mysqli_real_escape_string($connection, trim($_POST["email"]));
        $pass = password_hash($_POST["pass"], PASSWORD_BCRYPT);
        $is_admin = 0;

        $check_exist = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $check_exist);
        if (mysqli_num_rows($result) > 0) {
            $error_fields[] = "exist";
            mysqli_free_result($result);
        } else {
            $query = "INSERT INTO users (fname, lname, email, pass, is_admin) VALUES ('$fname', '$lname', '$email', '$pass', $is_admin)";
            if (mysqli_query($connection, $query)) {
                header("Location: login.php");
                exit;
            } else {
                echo "خطأ: " . mysqli_error($connection);
            }
        }
        mysqli_close($connection);
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
    <title>إنشاء حساب جديد</title>
    <style>
        /* Fix header overlap */
        body {
            padding-top: 60px;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8);
            transition: background-color 0.3s;
        }

        body.scrolled header {
            background-color: rgba(255, 255, 255, 1);
        }
    </style>
</head>

<body>
    <div class="signup-content">
        <div class="signup">
            <span>مفــــقــــود</span>
            <h1>إنشاء حساب جديد</h1>
            <form method="post">
                <?php if (in_array("exist", $error_fields)) echo "<p class='error'>هذا المستخدم موجود بالفعل</p>" ?>
                <div class="cont">
                    <div class="name">
                        <div class="box">
                            <input type="text" name="fname" placeholder="الاسم الأول" value="<?= isset($_POST["fname"]) ? htmlspecialchars($_POST["fname"]) : "" ?>" />
                            <?php if (in_array("fname", $error_fields)) echo "<p class='error-top'>أدخل الاسم الأول</p>" ?>
                        </div>
                        <div class="box">
                            <input type="text" name="lname" placeholder="الاسم الأخير" value="<?= isset($_POST["lname"]) ? htmlspecialchars($_POST["lname"]) : "" ?>" />
                            <?php if (in_array("lname", $error_fields)) echo "<p class='error-top'>أدخل الاسم الأخير</p>" ?>
                        </div>
                    </div>
                </div>
                <div class="cont">
                    <input type="email" name="email" placeholder="البريد الإلكتروني" value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "" ?>" />
                    <?php if (in_array("email", $error_fields)) echo "<p class='error-top'>أدخل بريد إلكتروني صحيح</p>" ?>
                </div>
                <div class="cont">
                    <div class="password">
                        <div class="box">
                            <input type="password" name="pass" placeholder="كلمة المرور" />
                            <?php if (in_array("pass", $error_fields)) echo "<p class='error-top'>كلمة المرور يجب أن تكون أكثر من 5 أحرف</p>" ?>
                        </div>
                        <div class="box">
                            <input type="password" name="passConfirm" placeholder="تأكيد كلمة المرور" />
                            <?php if (in_array("passConfirm", $error_fields)) echo "<p class='error-top'>كلمات المرور غير متطابقة</p>" ?>
                        </div>
                    </div>
                </div>
                <input type="submit" value="إنشاء حساب" />
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('scroll', function() {
            if (window.scrollY > 0) {
                document.body.classList.add('scrolled');
            } else {
                document.body.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>
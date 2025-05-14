<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// تعديل المسار لتضمين الهيدر
require "/app/partials/header.php";
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <title>MAFQOOD - مفــــقــــود</title>
</head>

<body>
    <div class="landing">
        <div class="overlay"></div>
        <div class="text">
            <h1>MAFQOOD - مفــــقــــود</h1>
            <p>
                البحث عن الأطفال المفقودين هي مبادرة إنسانية واجتماعية تعمل على لم شمل الأطفال المفقودين مع عائلاتهم
            </p>
            <a href="search" class="search">
                <i class="fa-solid fa-image"></i>
                البحث عن طريق صورة
            </a>
        </div>
    </div>

    <div class="content">
        <?php
        // require("config/database.php");
        $query = "SELECT * FROM `report` ORDER BY `report-data` DESC LIMIT 10";
        $result = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
            <!-- عرض البيانات هنا -->
        <?php endwhile ?>
    </div>

    <div class="operations">
        <h2>الفئات</h2>
        <div class="container">
            <div class="person-missing option">
                <img src="images/missing.png" alt="">
                <p>طفلي مفقود</p>
                <h3>للإبلاغ عن طفلك المفقود من خلال تقديم معلومات للمساعدة في العثور عليه</h3>
                <a href="missing">المزيد</a>
            </div>
            <div class="person-found option">
                <img src="images/find.png" alt="">
                <p>عثرت على طفل</p>
                <h3>للإبلاغ عن شخص تم العثور عليه لمساعدتهم على العودة إلى ذويه</h3>
                <a href="found">المزيد</a>
            </div>
            <div class="all-person option">
                <img src="images/children.png" alt="">
                <p>جميع الأطفال المفقودين</p>
                <h3>للبحث عن الأطفال المفقودين أو الذين تم العثور عليهم وتصفية النتائج</h3>
                <a href="all-people">المزيد</a>
            </div>
            <div class="image-search option">
                <img src="images/image.png" alt="">
                <p>البحث عن طريق صورة</p>
                <h3>للبحث عن صورة الطفل المفقود وإرجاع النتيجة</h3>
                <a href="search">المزيد</a>
            </div>
        </div>
    </div>

    <div class="contact-link">
        <div class="container">
            <a href="contact.php">تواصل معنا</a>
        </div>
    </div>

    <?php
    // تعديل المسار لتضمين الفوتر
    include __DIR__ . "/../partials/footer.php";
    ?>
    <script src="js/main.js"></script>
    <script src="js/header.js"></script>
</body>

</html>
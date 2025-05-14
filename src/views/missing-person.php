<?php
session_start();

// Store form data in session if there are validation errors
if (isset($_POST['child-name']) || isset($_POST['age']) || isset($_POST['gender']) || isset($_POST['health']) || isset($_POST['date']) || isset($_POST['child-city']) || isset($_POST['reporter-name']) || isset($_POST['relevance']) || isset($_POST['phone']) || isset($_POST['reporter-city'])) {
    $_SESSION['report-data'] = [
        'child-name' => $_POST['child-name'] ?? '',
        'age' => $_POST['age'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'health' => $_POST['health'] ?? '',
        'date' => $_POST['date'] ?? '',
        'child-city' => $_POST['child-city'] ?? '',
        'reporter-name' => $_POST['reporter-name'] ?? '',
        'relevance' => $_POST['relevance'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'reporter-city' => $_POST['reporter-city'] ?? ''
    ];
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/all.min.css" />
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/missing.css" />
    <link rel="shortcut icon" type="x-icon" href="../images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>تقرير طفل مفقود</title>
    <style>
        /* Fix header overlap */
        body {
            padding-top: 70px;
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
    <?php include "../partials/header.php" ?>
    <div class="mis-text">
        <h1>تقرير طفل مفقود</h1>
    </div>
    <div class="missing-content">
        <?php if (isset($_SESSION["report-errors"])) : ?>
        <p class="error">
            <?= $_SESSION["report-errors"];
                unset($_SESSION["report-errors"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["report-success"])) : ?>
        <p class="success">
            <?= $_SESSION["report-success"];
                unset($_SESSION["report-success"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["noface"])) : ?>
        <p class="error">
            <?= $_SESSION["noface"];
                unset($_SESSION["noface"]); ?>
        </p>
        <?php endif ?>
        <?php if (isset($_SESSION["exist"])) : ?>
        <p class="success" style="display: flex; justify-content: space-between">
            <?= $_SESSION["exist"];
                unset($_SESSION["exist"]); ?>
            <a href="search-image.php" style="color: var(--main-color)">ابحث هنا</a>
        </p>
        <?php endif ?>
        <form action="upload-missed" method="post" enctype="multipart/form-data">
            <div class="person-info">
                <p class="heading">معلومات الطفل المفقود</p>
                <div class="person-img">
                    <input type="file" id="file" accept="image/*" name="photo" hidden />
                    <div class="img-area" data-img="">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h3>رفع صورة للطفل</h3>
                    </div>
                    <button class="select-image">اختر صورة</button>
                </div>
                <div class="person-name box">
                    <label for="person-name" class="title">اسم الطفل</label>
                    <input type="text" placeholder="اسم الطفل" id="person-name" name="child-name"
                        value="<?= isset($_SESSION['report-data']["child-name"]) ? $_SESSION['report-data']["child-name"] : ""; 
                        if(isset($_SESSION["report-data"]["child-name"])) unset($_SESSION["report-data"]["child-name"]); ?>" />
                </div>
                <div class="person-age box">
                    <label for="person-age" class="title">عمر الطفل</label>
                    <input type="text" placeholder="عمر الطفل" id="person-age" name="age"
                        value="<?= isset($_SESSION['report-data']["age"]) ? $_SESSION['report-data']["age"] : "";
                        if(isset($_SESSION["report-data"]["age"])) unset($_SESSION["report-data"]["age"]); ?>" />
                </div>
                <div class="person-gender box">
                    <p class="title">جنس الطفل</p>
                    <div class="male gen">
                        <?php
                        $gen = "";
                        $heal = "";
                        if (isset($_SESSION["report-data"]["gender"])) {
                            $gen = $_SESSION["report-data"]["gender"];
                            unset($_SESSION["report-data"]["gender"]);
                        }
                        if (isset($_SESSION["report-data"]["health"])) {
                            $heal = $_SESSION["report-data"]["health"];
                            unset($_SESSION["report-data"]["health"]);
                        }
                        ?>
                        <input type="radio" name="gender" value="male" id="male"
                            <?= ($gen == "male") ? "checked" : "" ?> />
                        <label for="male">ذكر</label>
                    </div>
                    <div class="female gen">
                        <input type="radio" name="gender" value="female" id="female"
                            <?= ($gen == "female") ? "checked" : "" ?> />
                        <label for="female">أنثى</label>
                    </div>
                </div>
                <div class="person-health">
                    <p class="title">الحالة الصحية</p>
                    <div class="content">
                        <div class="normal">
                            <input type="radio" value="normal" name="health" id="normal"
                                <?= ($heal == "normal") ? "checked" : "" ?> />
                            <label for="normal">طبيعي</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="chronic" name="health" id="chronic"
                                <?= ($heal == "chronic") ? "checked" : "" ?> />
                            <label for="chronic">يعاني من مرض مزمن</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="disabled" name="health" id="disabled"
                                <?= ($heal == "disabled") ? "checked" : "" ?> />
                            <label for="disabled">معاق</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="place-date">
                <p class="heading">مكان وتاريخ البلاغ</p>
                <div class="date">
                    <label for="date" class="title">التاريخ</label>
                    <input type="date" name="date" id="date" value="<?= $_SESSION['report-data']["date"] ?? "";
                                                                    unset($_SESSION["report-data"]["date"]) ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label for="city" class="title">المدينة</label>
                        <select id="child-city" name="child-city"
                            data-city="<?= $_SESSION['report-data']["child-city"] ?? "";
                                                                                unset($_SESSION["report-data"]["child-city"]) ?>">
                            <option value="القاهرة" selected>القاهرة</option>
                            <option value="الإسكندرية">الإسكندرية</option>
                            <option value="الإسماعيلية">الإسماعيلية</option>
                            <option value="كفر الشيخ">كفر الشيخ</option>
                            <option value="أسوان">أسوان</option>
                            <option value="أسيوط">أسيوط</option>
                            <option value="الأقصر">الأقصر</option>
                            <option value="الوادي الجديد">الوادي الجديد</option>
                            <option value="شمال سيناء">شمال سيناء</option>
                            <option value="البحيرة">البحيرة</option>
                            <option value="بني سويف">بني سويف</option>
                            <option value="بورسعيد">بورسعيد</option>
                            <option value="البحر الأحمر">البحر الأحمر</option>
                            <option value="الجيزة">الجيزة</option>
                            <option value="الدقهلية">الدقهلية</option>
                            <option value="جنوب سيناء">جنوب سيناء</option>
                            <option value="دمياط">دمياط</option>
                            <option value="سوهاج">سوهاج</option>
                            <option value="السويس">السويس</option>
                            <option value="الشرقية">الشرقية</option>
                            <option value="الغربية">الغربية</option>
                            <option value="الفيوم">الفيوم</option>
                            <option value="القليوبية">القليوبية</option>
                            <option value="قنا">قنا</option>
                            <option value="مطروح">مطروح</option>
                            <option value="المنوفية">المنوفية</option>
                            <option value="المنيا">المنيا</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="reporter-info">
                <p class="heading">معلومات المبلغ</p>
                <div class="reporter-name box">
                    <label for="reporter-name" class="title">الاسم</label>
                    <input type="text" placeholder="الاسم الكامل" id="reporter-name" name="reporter-name"
                        value="<?= $_SESSION['report-data']["reporter-name"] ?? "";
                                                        unset($_SESSION["report-data"]["reporter-name"]) ?>" />
                </div>
                <div class="reporter-relation box">
                    <label for="reporter-relation" class="title">صلة القرابة بالطفل المفقود</label>
                    <input type="text" placeholder="صلة القرابة بالطفل المفقود" id="reporter-relation"
                        name="relevance"
                        value="<?= $_SESSION['report-data']["relevance"] ?? "";
                                                                        unset($_SESSION["report-data"]["relevance"]) ?>" />
                </div>
                <div class="reporter-phone box">
                    <label for="reporter-phone" class="title">رقم الهاتف</label>
                    <input type="text" maxlength="11" name="phone" placeholder="رقم الهاتف" id="reporter-phone"
                        value="<?= $_SESSION['report-data']["phone"] ?? "";
                                                                            unset($_SESSION["report-data"]["phone"]) ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label class="title">المدينة</label>
                        <select id="reporter-city" name="reporter-city"
                            data-city="<?= $_SESSION['report-data']["reporter-city"] ?? "" ?>">
                            <option value="القاهرة" selected>القاهرة</option>
                            <option value="الإسكندرية">الإسكندرية</option>
                            <option value="الإسماعيلية">الإسماعيلية</option>
                            <option value="كفر الشيخ">كفر الشيخ</option>
                            <option value="أسوان">أسوان</option>
                            <option value="أسيوط">أسيوط</option>
                            <option value="الأقصر">الأقصر</option>
                            <option value="الوادي الجديد">الوادي الجديد</option>
                            <option value="شمال سيناء">شمال سيناء</option>
                            <option value="البحيرة">البحيرة</option>
                            <option value="بني سويف">بني سويف</option>
                            <option value="بورسعيد">بورسعيد</option>
                            <option value="البحر الأحمر">البحر الأحمر</option>
                            <option value="الجيزة">الجيزة</option>
                            <option value="الدقهلية">الدقهلية</option>
                            <option value="جنوب سيناء">جنوب سيناء</option>
                            <option value="دمياط">دمياط</option>
                            <option value="سوهاج">سوهاج</option>
                            <option value="السويس">السويس</option>
                            <option value="الشرقية">الشرقية</option>
                            <option value="الغربية">الغربية</option>
                            <option value="الفيوم">الفيوم</option>
                            <option value="القليوبية">القليوبية</option>
                            <option value="قنا">قنا</option>
                            <option value="مطروح">مطروح</option>
                            <option value="المنوفية">المنوفية</option>
                            <option value="المنيا">المنيا</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="submit" value="إرسال" />
        </form>
    </div>
    <?php
    unset($_SESSION["report-data"]);
    ?>
    <?php if (!isset($_SESSION["id"])) : ?>
    <div class="login-error">
        <p>يجب تسجيل الدخول أولاً</p>
        <p>لرفع بلاغ</p>
        <div class="order">
            <button class="ok">حسنا</button>
            <button><a href="login">تسجيل الدخول</a></button>
        </div>
    </div>
    <div class="login-overlay"></div>
    <?php endif ?>
    <script src="js/missing-found.js"></script>
    <script src="js/header.js"></script>
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
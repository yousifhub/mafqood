<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/all-people.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>البحث عن جميع الأشخاص</title>
</head>

<body>
    <?php include "../partials/header.php" ?>
    <div class="icon-filter">
        <i class="fa-solid fa-filter"></i>
    </div>
    <div class="people-content">
        <div class="container">
            <div class="filter">
                <form action="" method="get">
                    <h2>تصفية النتائج</h2>
                    <div class="option search-in">
                        <p class="title">البحث في</p>
                        <select name="type" id="type" data-fltr="<?= isset($_GET["type"]) ? $_GET["type"] : "" ?>">
                            <option value="all">جميع الأطفال</option>
                            <option value="found">طفل معثور عليه</option>
                            <option value="missed">طفل مفقود</option>
                        </select>
                    </div>
                    <div class="option name">
                        <p class="title">الاسم</p>
                        <input type="text" name="name" placeholder="اسم الطفل" id="name" data-fltr="<?= isset($_GET["name"]) ? $_GET["name"] : "" ?>" />
                    </div>
                    <div class="option gender">
                        <p class="title">النوع</p>
                        <select name="gender" id="gender" data-fltr="<?= isset($_GET["gender"]) ? $_GET["gender"] : "" ?>">
                            <option value="all">جميع الأطفال</option>
                            <option value="male">ولد</option>
                            <option value="female">بنت</option>
                        </select>
                    </div>
                    <div class="option city">
                        <p class="title">المدينة</p>
                        <div class="select-box">
                            <div class="selected">اختر المدينة</div>
                            <div class="cities-container" id="city" data-fltr="<?= isset($_GET["city"]) ? $_GET["city"] : "" ?>">
                                <div class="city">
                                    <input type="radio" id="all" name="city" value="all" checked />
                                    <label for="all">جميع المدن</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="القاهرة" name="city" value="القاهرة" />
                                    <label for="القاهرة">القاهرة</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الإسكندرية" name="city" value="الإسكندرية" />
                                    <label for="الإسكندرية">الإسكندرية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الإسماعيلية" name="city" value="الإسماعيلية" />
                                    <label for="الإسماعيلية">الإسماعيلية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="كفر الشيخ" name="city" value="كفر الشيخ" />
                                    <label for="كفر الشيخ">كفر الشيخ</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="أسوان" name="city" value="أسوان" />
                                    <label for="أسوان">أسوان</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="أسيوط" name="city" value="أسيوط" />
                                    <label for="أسيوط">أسيوط</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الأقصر" name="city" value="الأقصر" />
                                    <label for="الأقصر">الأقصر</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الوادي الجديد" name="city" value="الوادي الجديد" />
                                    <label for="الوادي الجديد">الوادي الجديد</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="شمال سيناء" name="city" value="شمال سيناء" />
                                    <label for="شمال سيناء">شمال سيناء</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="البحيرة" name="city" value="البحيرة" />
                                    <label for="البحيرة">البحيرة</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="بني سويف" name="city" value="بني سويف" />
                                    <label for="بني سويف">بني سويف</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="بورسعيد" name="city" value="بورسعيد" />
                                    <label for="بورسعيد">بورسعيد</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="البحر الأحمر" name="city" value="البحر الأحمر" />
                                    <label for="البحر الأحمر">البحر الأحمر</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الجيزة" name="city" value="الجيزة" />
                                    <label for="الجيزة">الجيزة</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الدقهلية" name="city" value="الدقهلية" />
                                    <label for="الدقهلية">الدقهلية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="جنوب سيناء" name="city" value="جنوب سيناء" />
                                    <label for="جنوب سيناء">جنوب سيناء</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="دمياط" name="city" value="دمياط" />
                                    <label for="دمياط">دمياط</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="سوهاج" name="city" value="سوهاج" />
                                    <label for="سوهاج">سوهاج</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="السويس" name="city" value="السويس" />
                                    <label for="السويس">السويس</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الشرقية" name="city" value="الشرقية" />
                                    <label for="الشرقية">الشرقية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الغربية" name="city" value="الغربية" />
                                    <label for="الغربية">الغربية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="الفيوم" name="city" value="الفيوم" />
                                    <label for="الفيوم">الفيوم</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="القليوبية" name="city" value="القليوبية" />
                                    <label for="القليوبية">القليوبية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="قنا" name="city" value="قنا" />
                                    <label for="قنا">قنا</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="مطروح" name="city" value="مطروح" />
                                    <label for="مطروح">مطروح</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="المنوفية" name="city" value="المنوفية" />
                                    <label for="المنوفية">المنوفية</label>
                                </div>
                                <div class="city">
                                    <input type="radio" id="المنيا" name="city" value="المنيا" />
                                    <label for="المنيا">المنيا</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="option age" id="age" data-fltr="<?= isset($_GET["age"]) ? implode(",", $_GET["age"]) : "" ?>">
                        <p class="title">العمر</p>
                        <div class="year">
                            <input type="checkbox" id="0-10" name="age[]" value="0-10" />
                            <label for="0-10">0 - 10 عام</label>
                        </div>
                        <div class="year">
                            <input type="checkbox" id="11-18" name="age[]" value="11-20" />
                            <label for="11-20">11 - 18 عام</label>
                        </div>
                    </div>
                    <div class="option health" id="health" data-fltr="<?= isset($_GET["health"]) ? implode(",", $_GET["health"]) : "" ?>">
                        <p class="title">الحالة الصحية</p>
                        <div class="health-status">
                            <input type="checkbox" name="health[]" id="normal" value="normal" />
                            <label for="normal">طبيعي</label>
                        </div>
                        <div class="health-status">
                            <input type="checkbox" name="health[]" id="chronic" value="chronic" />
                            <label for="chronic">لديه مشكلة نفسية أو عقلية</label>
                        </div>
                        <div class="health-status">
                            <input type="checkbox" name="health[]" id="disabled" value="disabled" />
                            <label for="disabled">مريض</label>
                        </div>
                    </div>
                    <div class="bottons">
                        <input type="submit" value="تصفية" />
                        <a href="all-people.php">إعادة ضبط</a>
                    </div>
                </form>
            </div>
            <div class="people">
                <?php
                // require("config/database.php");
                $type = "";
                $name = "";
                $gender = "";
                $city = "";
                $age = array();
                $health = array();
                $query = "SELECT * FROM `report` WHERE 1 ";
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    if (isset($_GET["type"])) {
                        $type = $_GET["type"];
                    }
                    if (isset($_GET["gender"])) {
                        $gender = $_GET["gender"];
                    }
                    if (isset($_GET["city"])) {
                        $city = $_GET["city"];
                    }
                    if (isset($_GET["name"])) {
                        $name = mysqli_escape_string($connection, $_GET["name"]);
                    }
                    if (isset($_GET["age"])) {
                        $age = $_GET["age"];
                    }
                    if (isset($_GET["health"])) {
                        $health = $_GET["health"];
                    }
                    if (!empty($name)) {
                        $query .= "AND `child-name` LIKE '%" . $name . "%' ";
                    }
                    if (!empty($type) and $type != "all") {
                        $query .= "AND `type` = '" . $type . "' ";
                    }
                    if (!empty($gender) and $gender != "all") {
                        $query .= "AND `gender` = '" . $gender . "' ";
                    }
                    if (!empty($city) and $city != "all") {
                        $query .= "AND `child-city` = '" . $city . "' ";
                    }
                    if (!empty($age)) {
                        $query .= "AND (";
                        foreach ($age as $range) {
                            if ($range == "0-10") {
                                $query .= "`age` BETWEEN 0 AND 10 OR ";
                            } elseif ($range == "11-18") ;
                          
                        }
                        $query = rtrim($query, " OR ");
                        $query .= ") ";
                    }
                    if (!empty($health)) {
                        $health = "`health` IN('" . implode("','", $health) . "')";
                        $query .= "AND $health ";
                    }
                    // echo $query . "<br>";
                }
                $query .= "order by id desc";
                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result)) :

                ?>
                    <div class="box">
                        <a href="missing.php?id=<?= $row["id"] ?>">
                            <div class="photo">
                                <img src="uploads/<?= $row["photo"] ?>" alt="" />
                            </div>
                            <div class="text">
                                <h3>الاسم: <?= $row["child-name"] ?></h3>
                                <p>تاريخ البلاغ: <?= $row["date"] ?></p>
                            </div>
                            <div class="type <?= $row["type"] ?>"><?= $row["type"] == "found" ? "معثور عليه" : "مفقود" ?></div>
                        </a>
                    </div>
                <?php endwhile ?>
                <?php
                if (mysqli_num_rows($result) == 0) {
                    echo "<p class='empty'>لم يتم العثور على أشخاص بهذه البيانات</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="js/all-people.js"></script>
    <script src="js/header.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/missing.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Report-missing person</title>
    <style>
        /* Fix header overlap */
        body {
            padding-top: 60px; /* Adjust based on header height */
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            transition: background-color 0.3s;
        }

        body.scrolled header {
            background-color: rgba(255, 255, 255, 1); /* Solid background when scrolled */
        }
    </style>
</head>

<body>
    <?php include "partials/header.php" ?>
    <?php
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        // require("config/database.php");
        $report = "SELECT * from report WHERE `id`= '" . $id . "'";
        $report_result = mysqli_query($connection, $report);
        $report_row = mysqli_fetch_assoc($report_result);
        if (!empty($report_row)) {
            if ($_SESSION["id"] == $report_row["user-id"]) {
                $photo = $report_row["photo"];
                $child_name = $report_row["child-name"];
                $age = $report_row["age"];
                $gender = $report_row["gender"];
                $health = $report_row["health"];
                $date = $report_row["date"];
                $child_city = $report_row["child-city"];
                $reporter_name = $report_row["reporter-name"];
                $relevance = $report_row["relevance"];
                $reporter_city = $report_row["reporter-city"];
                $ssn = $report_row["ssn"];
                $phone = $report_row["phone"];
                $type = $report_row["type"];
                ////////////
            } else {
                header("location: manage-reports.php");
            }
        } else {
            header("location: manage-reports.php");
        }
    } else {
        header("location: manage-reports.php");
    }
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $photo_post = $_FILES["photo"];
        $time = time(); //make echo image name uniqe
        $photo_name = $time . $photo_post['name'];
        $photo_name = basename($photo_name);
        $photo_dir = "uploads/" . $photo_name;
        $photo_tmp_name = $photo_post['tmp_name'];
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $photo_name);
        $extension = end($extension);
        // move_uploaded_file($photo_tmp_name, $photo_dir);

        if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
            if (!in_array($extension, $allowed_files)) {
                $_SESSION['report-errors'] = "File should be png , jpg or jpeg";
            }
        }
        if (!(isset($_POST['child-name']) && !empty($_POST['child-name']))) {
            $_SESSION["report-errors"] = "Enter the missing person name";
        } elseif (!(isset($_POST['age']) && $_POST['age'] < 200) || empty($_POST["age"])) {
            $_SESSION["report-errors"] = "Enter the missing person age";
        } elseif (!isset($_POST["gender"])) {
            $_SESSION["report-errors"] = "Enter the missing person gender";
        } elseif (!isset($_POST["health"])) {
            $_SESSION["report-errors"] = "Enter the missing person health state";
        } elseif (!(isset($_POST["date"]) && !empty($_POST['date']))) {
            $_SESSION["report-errors"] = "Enter the missing person date";
        } elseif (!isset($_POST["child-city"])) {
            $_SESSION["report-errors"] = "Enter the missing person city";
        } elseif (!(isset($_POST['reporter-name']) && !empty($_POST['reporter-name']))) {
            $_SESSION["report-errors"] = "Enter your name";
        } elseif (!(isset($_POST['ssn']) && strlen($_POST['ssn']) == 14)) {
            $_SESSION["report-errors"] = "Enter your SSN";
        } elseif (!(isset($_POST['phone']) && strlen($_POST['phone']) == 11)) {
            $_SESSION["report-errors"] = "Enter your phone number";
        } elseif (!isset($_POST["reporter-city"])) {
            $_SESSION["report-errors"] = "Enter city where you live ";
        } elseif (isset($_POST["relevance"])) {
            if (!(isset($_POST['relevance']) && !empty($_POST['relevance'])))
                $_SESSION["report-errors"] = "Enter the relation with the missing person";
        }


        if (isset($_SESSION["report-errors"])) {
            $_SESSION['report-data'] = $_POST;
            // $_SESSION['report-img'] = $_FILES;
            // header("location: update-report.php?id=" . $id);
        } else {
            $child_name_update = mysqli_escape_string($connection, $_POST["child-name"]);
            $age_update = mysqli_escape_string($connection, $_POST["age"]);
            $gender_update = mysqli_escape_string($connection, $_POST["gender"]);
            $health_update = mysqli_escape_string($connection, $_POST["health"]);
            $date_update = mysqli_escape_string($connection, $_POST["date"]);
            $child_city_update = mysqli_escape_string($connection, $_POST["child-city"]);
            $reporter_name_update = mysqli_escape_string($connection, $_POST["reporter-name"]);
            if (isset($_POST["relevance"])) {
                $relevance_update = mysqli_escape_string($connection, $_POST["relevance"]);
            }
            $reporter_city_update = mysqli_escape_string($connection, $_POST["reporter-city"]);
            $ssn_update = mysqli_escape_string($connection, $_POST["ssn"]);
            $phone_update = mysqli_escape_string($connection, $_POST["phone"]);
            // $type_update = $_POST["type"];

            // require("config/database.php");
            if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK && isset($_POST["relevance"])) {
                $query = "UPDATE `report` SET `photo` = '" . $photo_name . "',
                `child-name` = '" . $child_name_update . "', 
                `age` = '" . $age_update . "', 
                `gender` = '" . $gender_update . "', 
                `health` = '" . $health_update . "', 
                `child-city` = '" . $child_city_update . "', 
                `date` = '" . $date_update . "' ,
                `reporter-name` = '" . $reporter_name_update . "' ,
                `ssn` = '" . $ssn_update . "' ,
                `phone` = '" . $phone_update . "' ,
                `reporter-city` = '" . $reporter_city_update . "' ,
                `relevance` = '" . $relevance_update . "' 
                WHERE `report`.`id` = " . $id;
                unlink("uploads/$photo");
                move_uploaded_file($photo_tmp_name, $photo_dir);
            } elseif ($_FILES["photo"]["error"] == UPLOAD_ERR_OK && !isset($_POST["relevance"])) {
                $query = "UPDATE `report` SET `photo` = '" . $photo_name . "',
                `child-name` = '" . $child_name_update . "', 
                `age` = '" . $age_update . "', 
                `gender` = '" . $gender_update . "', 
                `health` = '" . $health_update . "', 
                `child-city` = '" . $child_city_update . "', 
                `date` = '" . $date_update . "' ,
                `reporter-name` = '" . $reporter_name_update . "' ,
                `ssn` = '" . $ssn_update . "' ,
                `phone` = '" . $phone_update . "' ,
                `reporter-city` = '" . $reporter_city_update . "'
                WHERE `report`.`id` = " . $id;
                unlink("uploads/$photo");
                move_uploaded_file($photo_tmp_name, $photo_dir);
            } elseif ($_FILES["photo"]["error"] != UPLOAD_ERR_OK && isset($_POST["relevance"])) {
                $query = "UPDATE `report` SET `child-name` = '" . $child_name_update . "', 
                `age` = '" . $age_update . "', 
                `gender` = '" . $gender_update . "', 
                `health` = '" . $health_update . "', 
                `child-city` = '" . $child_city_update . "', 
                `date` = '" . $date_update . "' ,
                `reporter-name` = '" . $reporter_name_update . "' ,
                `ssn` = '" . $ssn_update . "' ,
                `phone` = '" . $phone_update . "' ,
                `reporter-city` = '" . $reporter_city_update . "' ,
                `relevance` = '" . $relevance_update . "' 
                WHERE `report`.`id` = " . $id;
            } elseif ($_FILES["photo"]["error"] != UPLOAD_ERR_OK && !isset($_POST["relevance"])) {
                $query = "UPDATE `report` SET `child-name` = '" . $child_name_update . "', 
                `age` = '" . $age_update . "', 
                `gender` = '" . $gender_update . "', 
                `health` = '" . $health_update . "', 
                `child-city` = '" . $child_city_update . "', 
                `date` = '" . $date_update . "' ,
                `reporter-name` = '" . $reporter_name_update . "' ,
                `ssn` = '" . $ssn_update . "' ,
                `phone` = '" . $phone_update . "' ,
                `reporter-city` = '" . $reporter_city_update . "'
                WHERE `report`.`id` = " . $id;
            }
            if (mysqli_query($connection, $query)) {
                $_SESSION['report-success'] = "The report has been updated successfully";
                header("location: update-report.php?id=" . $id);
                exit;
            } else {
                echo mysqli_error($connection);
            }
            mysqli_close($connection);
        }
    }
    ?>
    <div class="mis-text">
        <h1>Update my report</h1>
    </div>
    <?php
    if (!isset($_SESSION["id"])) {
        header("location: login.php");
    }
    ?>
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
        <form method="post" enctype="multipart/form-data" action="update-report.php?id=<?= $id ?>">
            <div class="person-info">
                <p class="heading">Missing person information</p>
                <div class="person-img">
                    <input type="file" id="file" accept="image/*" name="photo" hidden />
                    <div class="img-area" data-img="">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h3>Upload image for person</h3>
                        <img src="uploads/<?= $photo ?>" alt="photo">
                    </div>
                    <button class="select-image" type="button" onclick="document.getElementById('file').click();">Select Image</button>
                </div>
                <div class="person-name box">
                    <label for="person-name" class="title">person name</label>
                    <input type="text" placeholder="Person name" id="person-name" name="child-name" value="<?= $_SESSION['report-data']['child-name'] ?? $child_name ?>" />
                </div>
                <div class="person-age box">
                    <label for="person-age" class="title">person age</label>
                    <input type="text" placeholder="Person age" id="person-age" name="age" value="<?= $_SESSION['report-data']['age'] ?? $age ?>" />
                </div>
                <div class="person-gender box">
                    <p class="title">person gender</p>
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
                        <input type="radio" name="gender" value="male" id="male" gen="<?= $gen ?>" <?= ($gender == "male") ? "checked" : "" ?> />
                        <label for="male">male</label>
                    </div>
                    <div class="female gen">
                        <input type="radio" name="gender" value="female" id="female" gen="<?= $gen ?>" <?= ($gender == "female") ? "checked" : "" ?> />
                        <label for="female">female</label>
                    </div>
                </div>
                <script>
                    let gender = document.getElementById("male");
                    let allInputGender = document.querySelectorAll(".person-gender input");
                    if (gender.getAttribute("gen") != "") {
                        allInputGender.forEach(function(inp) {
                            if (inp.value == inp.getAttribute("gen")) {
                                allInputGender.forEach(function(e) {
                                    e.removeAttribute("checked");
                                });
                                inp.setAttribute("checked", "");
                            }
                        });
                    }
                </script>
                <div class="person-health">
                    <p class="title">health status</p>
                    <div class="content">
                        <div class="normal">
                            <input type="radio" value="normal" name="health" id="normal" heal="<?= $heal ?>" <?= ($health == "normal") ? "checked" : "" ?> />
                            <label for="normal">normal</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="chronic" name="health" id="chronic" heal="<?= $heal ?>" <?= ($health == "chronic") ? "checked" : "" ?> />
                            <label for="chronic">have chronic disease</label>
                        </div>
                        <div class="normal">
                            <input type="radio" value="disabled" name="health" id="disabled" heal="<?= $heal ?>" <?= ($health == "disabled") ? "checked" : "" ?> />
                            <label for="disabled">disabled</label>
                        </div>
                    </div>
                </div>
                <script>
                    let nor = document.getElementById("normal");
                    let allInput = document.querySelectorAll(".person-health input");
                    if (nor.getAttribute("heal") != "") {
                        allInput.forEach(function(inp) {
                            if (inp.value == inp.getAttribute("heal")) {
                                allInput.forEach(function(e) {
                                    e.removeAttribute("checked");
                                });
                                inp.setAttribute("checked", "");
                            }
                        });
                    }
                </script>
            </div>
            <div class="place-date">
                <p class="heading">The place and date of the person's loss</p>
                <div class="date">
                    <label for="date" class="title">Date</label>
                    <input type="date" name="date" id="date" value="<?= $_SESSION['report-data']['date'] ?? $date ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label for="city" class="title">City</label>
                        <select id="child-city" name="child-city" data-city="<?= $_SESSION['report-data']['child-city'] ?? $child_city ?>">
                            <option value="القاهرة">القاهرة</option>
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
                    <!-- <div class="town">
                        <label for="town" class="title">Town</label>
                        <select name="town" id="town"></select>
                    </div> -->
                </div>
            </div>
            <div class="reporter-info">
                <?php if ($type == "missed") : ?>
                    <p class="heading">Reporter information</p>
                <?php else : ?>
                    <p class="heading">Finder information</p>
                <?php endif ?>
                <div class="reporter-name box">
                    <label for="reporter-name" class="title">name</label>
                    <input type="text" placeholder="Full name" id="reporter-name" name="reporter-name" value="<?= $reporter_name ?>" />
                </div>
                <?php if ($type == "missed") : ?>
                    <div class="reporter-relation box">
                        <label for="reporter-relation" class="title">Relevance to the missed person</label>
                        <input type="text" placeholder="Relevance to the missed person" id="reporter-relation" name="relevance" value="<?= $_SESSION['report-data']['relevance'] ?? $relevance ?>" />
                    </div>
                <?php endif ?>
                <div class="reporter-ssn box">
                    <label for="reporter-ssn" class="title">SSN</label>
                    <input type="text" placeholder="SSN" maxlength="14" id="reporter-ssn" name="ssn" value="<?= $_SESSION['report-data']['ssn'] ?? $ssn ?>" />
                </div>
                <div class="reporter-phone box">
                    <label for="reporter-phone" class="title">phone</label>
                    <input type="text" maxlength="11" name="phone" placeholder="Phone number" id="reporter-phone" value="<?= $_SESSION['report-data']['phone'] ?? "0" . $phone ?>" />
                </div>
                <div class="place">
                    <div class="city">
                        <label class="title">City</label>
                        <select id="reporter-city" name="reporter-city" data-city="<?= $_SESSION['report-data']['reporter-city'] ?? $reporter_city ?>">
                            <option value="القاهرة">القاهرة</option>
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
                    <!-- <div class="town">
                        <label class="title">Town</label>
                        <select name="town" id="town"></select>
                    </div> -->
                </div>
            </div>
            <input type="submit" value="Update" />
        </form>
    </div>
    <?php
    unset($_SESSION["report-data"]);
    ?>
    <?php if (!isset($_SESSION["id"])) : ?>
        <div class="login-error">
            <p>You must login first to</p>
            <p>upload a report</p>
            <div class="order">
                <button class="ok">OK</button>
                <button><a href="login.php">Login</a></button>
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
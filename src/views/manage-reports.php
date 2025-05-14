<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/manage-reports.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <title>Manage my report</title>

</head>

<body>
    <?php include "partials/header.php" ?>
    <?php
    if (!isset($_SESSION["id"])) {
        header("location: login.php");
    } else {
        // require("config/database.php");
        $query = "SELECT `photo`, `child-name`, `date`, `child-city`, `id` , `type` , `report-data` FROM `report` WHERE `user-id`=" . $_SESSION["id"] . " ORDER BY `report-data` DESC";
        $result = mysqli_query($connection, $query);
    }
    ?>
    <div class="found-text">
        <h1>Manage my all reports</h1>
    </div>

    <div class="reports">
        <div class="container">
            <?php if (isset($_SESSION["report-success"])) : ?>
                <p class="success">
                    <?= $_SESSION["report-success"];
                    unset($_SESSION["report-success"]); ?>
                </p>
            <?php endif ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="con">
                    <div class="report">
                        <div class="info">
                            <div class="img">
                                <img src="uploads/<?= $row["photo"] ?>" alt="photo">
                            </div>
                            <div class="data">
                                <div class="box">
                                    <h2>name:</h2>
                                    <p><?= $row["child-name"] ?></p>
                                </div>
                                <div class="box">
                                    <h2>date:</h2>
                                    <p><?= $row["date"] ?></p>
                                </div>
                                <div class="box">
                                    <h2>city:</h2>
                                    <p><?= $row["child-city"] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="operation">
                            <a href="update-report.php?id=<?= $row["id"] ?>" class="update">update</a>
                            <button class="delete" data-id="<?= $row["id"] ?>">Delete</button>
                        </div>
                        <div class="type <?= $row["type"] ?>"><?= $row["type"] ?></div>
                    </div>
                </div>
            <?php } ?>
            <?php
            if (mysqli_num_rows($result) == 0) {
                echo "<p class='empty'>No reports uploaded yet </p>";
            }
            ?>
        </div>
    </div>
    <div class="msg">
        <p>Are you sure to delete</p>
        <p>this report</p>
        <div class="order">
            <button class="cancle">Cancel</button>
            <a href="" class="ok">Ok</a>
            <!-- <button class="ok">OK</button> -->
        </div>
    </div>
    <div class="msg-overlay"></div>

    <script src="js/header.js"></script>
    <script src="js/manage-reports.js"></script>
</body>

</html>
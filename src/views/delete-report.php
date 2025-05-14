<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: index.php");
    exit;
} else {
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        require("config/database.php");
        $report = "SELECT `id`, `user-id`, `photo` from report WHERE `id`= '" . $id . "'";
        $report_result = mysqli_query($connection, $report);
        $report_row = mysqli_fetch_assoc($report_result);
        if (!empty($report_row)) {
            if ($_SESSION["id"] == $report_row["user-id"]) {
                $photo = $report_row["photo"];
                unlink("uploads/$photo");
                $query = "DELETE FROM report WHERE id = '" . $id . "' ";
                if (mysqli_query($connection, $query)) {
                    $_SESSION['report-success'] = "The report has been deleted successfully";
                    header("location: manage-reports.php");
                    exit;
                }
            } else {
                header("location: manage-reports.php");
                exit;
            }
        } else {
            header("location: manage-reports.php");
            exit;
        }
    } else {
        header("location: manage-reports.php");
        exit;
    }
}

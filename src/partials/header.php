<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require  '/app/config/database.php';
require  '/app/config/constants.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <link rel="stylesheet" href="<?= ROOT_URL . "css/main.css" ?>">
    <script src="<?= ROOT_URL . "js/header.js" ?>" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<div class="header">
    <div class="container">
        <!-- الشعار -->
        <div class="logo">
            <a href="/">
                <div class="content">
                    <img src="images/logo.png" alt="logo" />
                    <p>MAFQOOD - مفــــقــــود</p>
                </div>
            </a>
        </div>

        <!-- زر القائمة الجانبية -->
        <div class="toggle-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- قائمة التنقل -->
        <div class="nav">
            <ul class="links">
                <?php if (!empty($_SESSION["admin"])) : ?>
                    <li><a href="/admin/dashboard.php">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="/missing">طفلي مفقود</a></li>
                <li><a href="/found">عثرت علي طفل</a></li>
                <li><a href="/search">بحث بصورة</a></li>
                <li><a href="/">الصفحة الرئيسية</a></li>
            </ul>

            <!-- الملف الشخصي -->
            <?php if (!empty($_SESSION["id"])) : ?>
                <div class="profile">
                    <p class="profile-toggle">أهلاً - <?= htmlspecialchars($_SESSION["fname"]) ?> <i class="fa-solid fa-caret-down"></i></p>
                    <div class="profile-menu">
                        <a href="/profile.php">البروفايل</a>
                        <a href="/logout.php">تسجيل الخروج</a>
                    </div>
                </div>
            <?php else : ?>
                <div class="profile">
                    <a href="/login">تسجيل دخول / إنشاء حساب</a>
                </div>
            <?php endif; ?>

            <!-- اللغة -->
            <div class="lang"></div>
        </div>
    </div>
</div>

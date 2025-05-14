<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/all.min.css" />
    <link rel="stylesheet" href="/css/normalize.css" />
    <link rel="stylesheet" href="/css/main.css" />
    <link rel="stylesheet" href="/css/missing.css" />
    <link rel="stylesheet" href="/css/search-image.css" />
    <link rel="shortcut icon" type="x-icon" href="images/logo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <title>البحث عن طريق الصورة</title>
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
            background-color: rgba(255, 255, 255, 0.95); /* More solid background */
            transition: background-color 0.3s;
        }

        body.scrolled header {
            background-color: rgba(255, 255, 255, 1); /* Solid background when scrolled */
        }
    </style>
</head>

<body>
    <?php include "../partials/header.php" ?>
    <!-- Soon Overlay -->
    <div class="soon-overlay">
        <div class="soon-text">Soon</div>
    </div>
    <div class="image-text">
        <div class="container">
            <div class="text-center">
                <p>قم برفع صورة والبحث</p>
            </div>
        </div>
    </div>
    <div class="search-image">
        <form action="res-image.php" method="post" enctype="multipart/form-data">
            <div class="container">
                <div class="person-img">
                    <input type="file" id="file" accept="image/*" name="img" hidden required />
                    <div class="img-area" data-img="">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <h3>قم برفع صورة للشخص</h3>
                    </div>
                    <button class="select-image">اختر صورة</button>
                </div>
                <input type="submit" class="search test-ajax" value="بحث">
                <div class="result">
                    <div class="img-area">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>لا توجد نتائج حتى الآن</h3>
                        <img src="" hidden alt="الصورة">
                    </div>
                    <a href="" class="text off">عرض التفاصيل</a>
                </div>
            </div>
        </form>
    </div>
    <div class="con-loader hide">
        <div class="loader"></div>يرجى الانتظار...
    </div>
    <div class="overlay hide"></div>

    <script src="js/missing-found.js"></script>
    <script src="js/header.js"></script>
    <script>
    let disLink = document.querySelector(".result a");
    disLink.addEventListener("click", function(e) {
        if (disLink.getAttribute("href") == "") {
            e.preventDefault();
        }
    });

    // Add an event listener to the form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        // loading
        let load = document.querySelector(".con-loader");
        let overlay = document.querySelector(".overlay");
        load.classList.remove("hide");
        overlay.classList.remove("hide");

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost:5000/test', true); // Flask API endpoint
        xhr.onload = function() {
            load.classList.add("hide");
            overlay.classList.add("hide");
            if (xhr.status === 200) {
                let res = document.querySelector(".result");
                let link = res.querySelector("a");
                let img = res.querySelector("img");
                let imgArea = document.querySelector(".result .img-area");
                let txt = imgArea.querySelector("h3");
                let icon = imgArea.querySelector("i");
                var jsonObject = JSON.parse(this.responseText);

                if (jsonObject.found === "no") {
                    txt.innerHTML = "لم يتم العثور على شخص بهذه الصورة";
                    txt.classList.add("warning");
                    icon.classList.add("warning");
                    img.setAttribute("src", "");
                    link.setAttribute("href", "");
                    link.classList.add("off");
                    img.setAttribute("hidden", "");
                } else if (jsonObject.found === "yes") {
                    img.removeAttribute("hidden");
                    link.classList.remove("off");
                    img.setAttribute("src", jsonObject.image);
                    link.setAttribute("href", "missing.php?id=" + jsonObject.id);
                }
            } else {
                console.error('Failed to connect to the Flask API.');
            }
        };
        xhr.send(formData);
    });

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
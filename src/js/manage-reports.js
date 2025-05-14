let del = document.querySelectorAll(".delete");
let img = document.querySelector(".img");
let cancle = document.querySelector(".cancle");
let ok = document.querySelector(".ok");
let msg = document.querySelector(".msg");
let overlay = document.querySelector(".msg-overlay");
let id = "";
del.forEach(ele => {
    ele.addEventListener("click", function () {
        overlay.style.display = "block";
        msg.style.display = "flex";
        id = ele.dataset.id;
        ok.href = "delete-report.php?id=" + id;
    });
});
cancle.addEventListener("click", function () {
    overlay.style.display = "none";
    msg.style.display = "none";
    ok.href = "";
});
ok.addEventListener("click", function () {
    overlay.style.display = "none";
    msg.style.display = "none";
    window.location.href = "delete-report.php?id=" + id; // توجيه المستخدم إلى صفحة الحذف
});
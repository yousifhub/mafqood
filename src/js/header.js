let toggle = document.querySelector(".toggle-menu");
let links = document.querySelector(".header .nav");
toggle.addEventListener("click", function (e) {
  e.stopPropagation();
  links.classList.toggle("open");
});
links.onclick = function (e) {
  e.stopPropagation();
};
document.addEventListener("click", (e) => {
  if (e.target !== links && e.target !== toggle) {
    if (links.classList.contains("open")) {
      links.classList.remove("open");
    }
  }
});

let simiTogo = document.querySelector(".nav .profile");
let profile = document.querySelector(".nav .data");
simiTogo.addEventListener("click", function (e) {
  e.stopPropagation();
  profile.classList.toggle("open");
})

// profile.onclick = function (e) {
//   e.stopPropagation();
// };

if (profile !== null) {
  profile.onclick = function (e) {
    e.stopPropagation();
  };
}

// document.addEventListener("click",function(e) {
//   if(e.target == profile) {
//     profile.stopPropagation();
//   }
// })

if (profile !== null) {
  document.addEventListener("click", (e) => {
    if (e.target !== profile && e.target !== simiTogo) {
      if (profile.classList.contains("open")) {
        profile.classList.remove("open");
      }
    }
  });
}
// document.addEventListener("click", (e) => {
//   if (e.target !== profile && e.target !== simiTogo) {
//     if (profile.classList.contains("open")) {
//       profile.classList.remove("open");
//     }
//   }
// });

//dark mood
let darkIcon = document.querySelector(".fa-moon");
let darkLocal = window.localStorage.getItem("dark");
if (darkLocal !== null && darkLocal === "yes") {
  document.documentElement.classList.add("dark");
  darkIcon.classList.toggle("fa-moon");
  darkIcon.classList.toggle("fa-sun");
}

darkIcon.addEventListener("click", function () {
  // <i class="fa-solid fa-sun"></i>
  darkIcon.classList.toggle("fa-moon");
  darkIcon.classList.toggle("fa-sun");
  if (darkIcon.classList.contains("fa-sun")) {
    window.localStorage.setItem("dark", "yes");
    document.documentElement.classList.add("dark");
  } else {
    window.localStorage.setItem("dark", "no");
    document.documentElement.classList.remove("dark");
  }
});

// تشغيل أزرار الهيدر
let headerLinks = document.querySelectorAll(".header .nav .links a");
headerLinks.forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = this.href; // توجيه المستخدم إلى الرابط
  });
});

// تشغيل زر الملف الشخصي
let profileLinks = document.querySelectorAll(".profile-menu a");
profileLinks.forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = this.href; // توجيه المستخدم إلى الرابط
  });
});

let links = document.querySelectorAll(".header .nav .links a");
links.forEach(link => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    window.location.href = this.href; // توجيه المستخدم إلى الرابط
  });
});

// تشغيل زرار الهيدر
let headerButton = document.querySelector(".header .nav .search-button"); // استبدل "search-button" بالـ class أو id الخاص بزر الهيدر
if (headerButton) {
  headerButton.addEventListener("click", function (e) {
    e.preventDefault();
    // قم بتوجيه المستخدم إلى صفحة البحث أو تنفيذ أي منطق مشابه
    window.location.href = "search-image.php"; // استبدل الرابط بالصفحة المطلوبة
  });
}
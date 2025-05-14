const selected = document.querySelector(".selected");
const citiesContainer = document.querySelector(".cities-container");
const cityList = citiesContainer.querySelectorAll(".city");

selected.addEventListener("click", () => {
  citiesContainer.classList.toggle("active");
  selected.classList.toggle("rotate");
  selected.classList.toggle("clicked");
});

cityList.forEach((e) => {
  e.addEventListener("click", () => {
    selected.innerHTML = e.querySelector("label").innerHTML;
    selected.classList.remove("clicked");
    selected.classList.remove("rotate");
    citiesContainer.classList.remove("active");
    window.location.href = "all-people.php?city=" + e.querySelector("input").value; // توجيه المستخدم إلى صفحة البحث
  });
});

//filter
const iconFilter = document.querySelector(".icon-filter");
iconFilter.addEventListener("click", function () {
  iconFilter.classList.toggle("clicked");
  if (iconFilter.classList.contains("clicked")) {
    let overlay = document.createElement("div");
    overlay.className = "overlay";
    document.body.appendChild(overlay);
  } else {
    document.querySelector(".overlay").remove();
  }
  const filter = document.querySelector(".filter");
  filter.classList.toggle("show");
});

// save values of filter in all inputs
let name = document.getElementById("name");
let type = document.getElementById("type");
let gender = document.getElementById("gender");
let city = document.getElementById("city");
let age = document.getElementById("age");
let health = document.getElementById("health");
let ageArr = age.dataset.fltr.split(",");
let healthArr = health.dataset.fltr.split(",");


name.value = name.dataset.fltr;
function selectinput(ele) {
  if (ele.getAttribute("data-fltr")) {
    let options = ele.querySelectorAll("option");
    options.forEach((e) => {
      if (e.value == ele.dataset.fltr) {
        e.setAttribute("selected", "");
      }
    })
  }
}

function radioInput(ele) {
  if (ele.getAttribute("data-fltr")) {
    let inputs = ele.querySelectorAll("input");
    inputs.forEach((e) => {
      if (e.value == ele.dataset.fltr) {
        e.setAttribute("checked", "");
      }
    })
  }
}
if (citiesContainer.getAttribute("data-fltr")) {
  selected.innerHTML = citiesContainer.getAttribute("data-fltr");
}

function setAgeAndHealth(ele, arr) {
  if (arr) {
    for (let i = 0; i < arr.length; i++) {
      let chechboxs = ele.querySelectorAll("input");
      chechboxs.forEach(function (inp) {
        if (inp.value == arr[i]) {
          inp.setAttribute("checked", "");
        }
      })
    }
  }
}

selectinput(type);
selectinput(gender);
radioInput(city);
setAgeAndHealth(health, healthArr);
setAgeAndHealth(age, ageArr);


// if(ageArr){
//   for(let i = 0; i<ageArr.length; i++) {
//     let chechboxs = age.querySelectorAll("input");
//     chechboxs.forEach(function(inp){
//       if (inp.value == ageArr[i]) {
//         inp.setAttribute("checked","");
//       }
//     })
//   }
// }



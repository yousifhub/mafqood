const selectImage = document.querySelector(".select-image");
const inputFile = document.querySelector("#file");
const imgArea = document.querySelector(".img-area");

selectImage.addEventListener("click", function (e) {
  e.preventDefault();
  inputFile.click();
});
inputFile.addEventListener("change", function () {
  const image = this.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    const allImg = imgArea.querySelectorAll("img");
    allImg.forEach((item) => item.remove());
    const imgUrl = reader.result;
    const img = document.createElement("img");
    img.src = imgUrl;
    imgArea.appendChild(img);
    imgArea.classList.add("active");
    imgArea.dataset.img = image.name;
  };
  reader.readAsDataURL(image);
});

let personAge = document.querySelector("#person-age");
let reporterPhone = document.querySelector("#reporter-phone");
let founderPhone = document.querySelector("#founder-phone");
let reporterSsn = document.querySelector("#reporter-ssn");
let founderSsn = document.querySelector("#founder-ssn");

document.addEventListener("input", function (e) {
  if (e.target == personAge) onlyNumber(e.target);
});
document.addEventListener("input", function (e) {
  if (e.target == reporterPhone) onlyNumber(e.target);
});
document.addEventListener("input", function (e) {
  if (e.target == founderPhone) onlyNumber(e.target);
});
document.addEventListener("input", function (e) {
  if (e.target == reporterSsn) onlyNumber(e.target);
});
document.addEventListener("input", function (e) {
  if (e.target == founderSsn) onlyNumber(e.target);
});
// personAge.addEventListener("input", onlyNumber);
// reporterPhone.addEventListener("input", onlyNumber);
// founderPhone.addEventListener("input", onlyNumber);
// reporterSsn.addEventListener("input", onlyNumber);
// founderSsn.addEventListener("input", onlyNumber);
function onlyNumber(ele) {
  ele.value = ele.value.replace(/[^0-9]/g, "");
}

// error login
let ok = document.querySelector(".ok");
let overlay = document.querySelector(".login-overlay");
let popwindow = document.querySelector(".login-error");
document.addEventListener("click", function(e){
  if(e.target==ok){
    popwindow.remove();
    overlay.remove();
  }
});

// city for reporter and child;
let childCity = document.getElementById("child-city");
let childAttr = childCity.getAttribute("data-city");
let childOptions = childCity.querySelectorAll ("option");
let reporterCity = document.getElementById("reporter-city");
let reporterAttr = reporterCity.getAttribute("data-city");
let reporterOptions = reporterCity.querySelectorAll ("option");
function setAttr (ele , attr) {
  ele.forEach(function(e) {
    if (e.value == attr) {
      e.setAttribute("selected","");
    };
  });
};

setAttr(childOptions, childAttr);
setAttr(reporterOptions, reporterAttr);

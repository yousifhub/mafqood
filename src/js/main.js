// random background
let landBack = document.querySelector(".landing");
let imgArr = [
  "back1.jpg",

];

let backInterval;
setInterval(function () {
  let rand = Math.floor(Math.random() * imgArr.length);
  landBack.style.backgroundImage = `url(images/${imgArr[rand]})`;
}, 5000);

// event on scroll
let operations = document.querySelector(".operations");
let option = document.querySelectorAll(".operations .option");
window.onscroll = function () {
  let operationsOffsetTop = operations.offsetTop;
  let operationsHeight = operations.offsetHeight;
  let windowHeight = this.innerHeight;
  let windowTop = this.pageYOffset;
  if (windowTop > operationsOffsetTop - operationsHeight /* + 100 */) {
    option.forEach((ele) => {
      ele.classList.add("animation");
    });
  }
};
let testAjax = document.querySelector(".test-ajax");
testAjax.addEventListener("click", function() {
    let request = new XMLHttpRequest();
    request.open("POST", "res-image.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    let data = "id="+`${this.dataset.id}`;
    request.send(data);
    overlay.classList.add("start");
    modelView.classList.add("start");
    close.addEventListener("click", function (){
        overlay.classList.remove("start");
        modelView.classList.remove("start");
    })
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            console.log (request)
            document.querySelector(".model-view .id").innerHTML = request.response;
            const myObjct = JSON.parse(this.responseText);
            modelView.querySelector(".child-name span").innerHTML = myObjct["child-name"];
            modelView.querySelector(".age span").innerHTML = myObjct.age;
            modelView.querySelector(".gender span").innerHTML = myObjct.gender;
            modelView.querySelector(".health-state span").innerHTML = myObjct.health;
            modelView.querySelector(".type span").innerHTML = myObjct.type;
            modelView.querySelector(".date span").innerHTML = myObjct.date;
            modelView.querySelector(".child-city span").innerHTML = myObjct["child-city"];
            modelView.querySelector(".reporter-name span").innerHTML = myObjct["reporter-name"];
            modelView.querySelector(".reporter-city span").innerHTML = myObjct["reporter-city"];
            modelView.querySelector(".phone span").innerHTML = myObjct.phone;
            modelView.querySelector(".relation span").innerHTML = myObjct.relevance;
            modelView.querySelector(".id span").innerHTML = myObjct.user.id;
            modelView.querySelector(".email span").innerHTML = myObjct.user.email;
            modelView.querySelector(".name span").innerHTML = myObjct.user.fname +" "+ myObjct.user.lname;
        }
    }
    request.onload = function() {
        // Handle response
        console.log(request.responseText);
    };
    console.log (this.dataset.id);
})
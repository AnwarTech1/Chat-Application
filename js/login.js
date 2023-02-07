const form = document.querySelector(".login form"),
  continueBtn = form.querySelector(".button input"),
  errorText = form.querySelector(".error-txt");

form.onsubmit = function (e) {
  e.preventDefault();
};

continueBtn.onclick = function () {
  // Ajax Code
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/login.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        console.log(data);
        if (data == "success") {
          location.href = "users.php";
        } else {
          errorText.textContent = data;
          errorText.style.display = "block";
        }
      }
    }
  };
  // send the form data through ajax to php
  let formData = new FormData(form);
  xhr.send(formData);
};

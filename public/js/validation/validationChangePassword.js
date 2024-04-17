import {checkContentData} from "./validation.js";

(function () {
  'use strict'
  let forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        checkContentData(form.newPassword, form.newPassword.parentElement.getElementsByTagName("div")[0], event)
        checkContentData(form.repeatPassword, form.repeatPassword.parentElement.getElementsByTagName("div")[0], event)
        form.classList.add('was-validated');
      }, false)
    })
})()


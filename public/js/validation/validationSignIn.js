import {validity, checkContentData} from "./validation.js";

window.onload = function () {
    var k = document.getElementsByTagName('button')
    for (var i = 0; i < k.length; i++) {
        k[i].addEventListener("click", validationSignIn);
    }
}
var validationSignIn = function () {
    if (document.getElementById("registerPage").hidden === false) {
        validity()
        let forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    checkContentData(form.newPassword, form.newPassword.parentElement.getElementsByTagName("div")[0], event)
                    checkContentData(form.repeatPassword, form.repeatPassword.parentElement.getElementsByTagName("div")[0], event)
                    form.classList.add('was-validated');
                }, false)
            })
        document.getElementById("registerPage").hidden = true;
        document.getElementById("signInPage").hidden = false
    } else {
        validity();
    }
}

document.getElementById("forgotPasswordButton").onclick = function () {
    document.getElementById("signInPage").hidden = true;
    document.getElementById("registerPage").hidden = true;
    document.getElementById("forgotPasswordPage").hidden = false;
}

document.getElementById("registerButton").onclick = function () {
    document.getElementById("signInPage").hidden = true;
    document.getElementById("registerPage").hidden = false;
    document.getElementById("forgotPasswordPage").hidden = true;
}

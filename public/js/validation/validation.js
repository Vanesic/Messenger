let
//Регулярные выражения
  regEmail = /^((([0-9A-Za-z]{1}[-0-9A-z.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u,
  regPasswordLatinAndNumbers = /^[a-zA-Z0-9]*$/,
  regPhone = /^\+?(\d{1,3})?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$/;

var checkContentData = function (element, text, event) {
  if (element.value.length === 0) {
    element.setCustomValidity("NotNull");
    text.textContent = "Enter " + element.name;
    event.preventDefault()
    event.stopPropagation()
    return;
  }
  switch (element.name) {
    case "phone[]":
      if (!regPhone.exec(element.value)) {
        element.setCustomValidity("NotNull");
        text.textContent = "Incorrect phone!";
        event.preventDefault();
        event.stopPropagation();
      } else {
        element.setCustomValidity("");
      }
      break;
    case "email[]":
      if (!regEmail.exec(element.value)) {
        element.setCustomValidity("NotNull");
        text.textContent = "Incorrect email!";
        event.preventDefault();
        event.stopPropagation();
      } else {
        element.setCustomValidity("");
      }
      break;
    case "password":
    case "newPassword":
      if (element.value.length < 8) {
        element.setCustomValidity("NotNull");
        text.textContent = "Password do not be less 8 letters!";
        event.preventDefault();
        event.stopPropagation();
      } else if (!regPasswordLatinAndNumbers.exec(element.value)) {
        element.setCustomValidity("NotNull");
        text.textContent = "Use latin letters and numbers";
        event.preventDefault();
        event.stopPropagation();
      } else {
        element.setCustomValidity("");
      }
      break;
    case "repeatPassword":
      if (element.value !== document.getElementsByName("newPassword")[0].value) {
        element.setCustomValidity("NotNull");
        text.textContent = "Passwords aren't equal!";
      } else {
        element.setCustomValidity("");
      }
      break;
    default:
      alert("Error")
      break;
  }
}

var validity = function () {
  let forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var len;
        len = form.elements.namedItem("email[]").length;
        if (len === undefined) {
          len += 1;
        } else {
          for (let i = 0; i < len; i++) {
            var emails = document.getElementsByName("email[]");
            checkContentData(emails[i], emails[i].parentElement.getElementsByTagName("div")[0], event)
          }
        }
        form.classList.add('was-validated');
      }, false)
    })
}

export {validity, checkContentData};


document.getElementById("counterOfContacts").textContent = "(" + (delButtons.length + 1).toString() + ")"; document.getElementById("counterOfContacts").textContent = "(" + (delButtons.length + 1).toString() + ")";import {validity, checkContentData} from "./validation.js";

const
  lastInputEmail = document.querySelector('#emailArea'), //Поле с почтами
  lastInputPhone = document.querySelector('#phoneArea'); //Поле с телефонами

window.onload = function () {
  var k = document.getElementsByTagName('button')
  for (var i = 0; i < k.length; i++) {
    if (k[i].name !== "closeButton") {
      k[i].addEventListener("click", validationEditPage);
    } else {
      k[i].addEventListener("click", closes);
    }
  }
}

var validationEditPage = function (){
  validity();
  let forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var len;
        len = form.elements.namedItem("phone[]").length;
        if (len === undefined) {
          len += 1;
        } else {
          for (let i = 0; i < len; i++) {
            var phones = document.getElementsByName("phone[]")[i];
            checkContentData(phones, phones.parentElement.getElementsByTagName("div")[0], event)
          }
        }
        form.classList.add('was-validated');
      }, false)
    })
}

var closes = function () {
  if (this.parentElement.parentElement.getElementsByTagName('input').length > 1) {
    this.parentElement.remove();
  } else {
    alert('You must have at least one email and phone number');
  }
}

document.getElementById('addPhone').onclick = function (e) {
  e.preventDefault();
  var z = document.createElement('div');
  z.classList.add("position-relative");
  z.classList.add("mt-2");
  z.classList.add("justify-content-lg-center");
  z.classList.add("w-100");
  z.classList.add("d-flex");
  z.classList.add("align-self-center");
  z.innerHTML = '<input name="phone[]" type="phone" class="form-control me-1 fw-normal"\n' +
    '                           placeholder="Phone number" value="+79081808697" required>' +
    '<div class="invalid-tooltip" id="warningMesPhone">\n' +
    '                      Incorrect phone number!\n' +
    '                    </div>';
  var closeButton = document.createElement('button');
  closeButton.classList.add('btn-close');
  closeButton.classList.add('mt-2');
  closeButton.type = 'button';
  closeButton.name = 'closeButton';
  closeButton.addEventListener('click', closes);
  z.appendChild(closeButton);
  lastInputPhone.appendChild(z).after(document.getElementById('addPhone'));
}

document.getElementById('addEmail').onclick = function (e) {
  e.preventDefault();
  var z = document.createElement('div');
  z.classList.add("position-relative");
  z.classList.add("mt-2");
  z.classList.add("justify-content-lg-center");
  z.classList.add("w-100");
  z.classList.add("d-flex");
  z.classList.add("align-self-center");
  z.innerHTML = '<input name="email[]" type="email" class="form-control me-1 fw-normal"\n' +
    '                           placeholder="Email" value="dudinivan15@gmail.com" required>' +
    '<div class="invalid-tooltip" id="warningMesEmail">\n' +
    '                      Incorrect email!\n' +
    '                    </div>';
  var closeButton = document.createElement('button');
  closeButton.classList.add('btn-close');
  closeButton.classList.add('mt-2');
  closeButton.type = 'button';
  closeButton.name = 'closeButton';
  closeButton.addEventListener('click', closes);
  z.appendChild(closeButton);
  lastInputEmail.appendChild(z).after(document.getElementById('addEmail'));
}

const fileUploader = document.getElementById('file');
const reader = new FileReader();
const imageGrid = document.getElementById('avatarGrid');
const oldPhoto = document.getElementById('avatar');


$("form").submit(function (event) {
    var lastNameValue = document.getElementsByName('lastNameInput')[0].value;
    var firstNameValue = document.getElementsByName('firstNameInput')[0].value;
    var middleNameValue = document.getElementsByName('middleNameInput')[0].value;
    var genderValue = document.getElementById('dropdownMenuGender').value;
    var dobValue = document.getElementsByName('date')[0].value;
    var emails = document.getElementsByName('email[]');
    var telephones = document.getElementsByName('phone[]');
    var skypeValues = document.getElementsByName('skypeInput')[0].value;
    var isAdmin = document.getElementsByName("admin")[0].value;
    var isActive = document.getElementsByName("active")[0].value;
    var passwordValue = document.getElementsByName("passwordInput")[0].value;
    var emailsValue = [];
    var telephonesValue = [];
    var photoSrc = document.getElementById("avatar").src;
    var userId = window.location.pathname;
    userId = userId.split("/edit/");
    console.log(userId)
    for (let i = 0; i < emails.length; i++) {
        emailsValue.push(emails[i].value);
    }
    for (let i = 0; i < telephones.length; i++) {
        telephonesValue.push(telephones[i].value);
    }

    $.post('/admin/edit', {
        firstName: firstNameValue,
        lastName: lastNameValue,
        middleName: middleNameValue,
        gender: genderValue,
        emails: emailsValue,
        telephones: telephonesValue,
        dob: dobValue,
        skype: skypeValues,
        photo: photoSrc,
        isAdmin: isAdmin,
        isActive: isActive,
        password: passwordValue,
        id: 1,
        userId: userId[1],
    });
    event.preventDefault();
});

$("#deleteButton").click(function (event) {
    var userId = window.location.pathname;
    userId = userId.split("/admin/edit/");
    $.post('/admin/edit', {
        id: 0,
        userId: userId[1],
    });
    event.preventDefault();
})
fileUploader.addEventListener('change', (event) => {
    const files = event.target.files;
    const file = files[0];
    reader.readAsDataURL(file);

    reader.addEventListener('load', (event) => {
        const img = document.createElement('img');
        oldPhoto.remove();
        img.classList.add("mt-0");
        img.classList.add("m-4");
        img.id = "avatar";
        imageGrid.appendChild(img);
        img.src = "/media/" + file["name"];
        event.preventDefault();
    });
});

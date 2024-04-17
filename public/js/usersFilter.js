$("form").submit(function (event) {
    var searchLineValue = document.getElementById('searchLine').value;
    var genderValue = document.getElementsByName('dropdownGender')[0].value;
    var postValue = document.getElementsByName('dropdownPost')[0].value;
    var dateValues = document.getElementsByName('date[]');
    var dobBefore = dateValues[0].value;
    var dobAfter = dateValues[1].value;

    $.post('/users', {
        searchLine: searchLineValue,
        gender: genderValue,
        post: postValue,
        dobBefore: dobBefore,
        dobAfter: dobAfter,
        id: 0,
    }, function (data) {
        parsing(data);
    });
    event.preventDefault();
});

$(".page-item").click(function (event) {
    var page = $(this);
    var prevent = document.querySelector(".pagination").querySelectorAll(".active");
    var number = page[0].querySelectorAll(".page-link");
    var pageNumber;
    if (number[0].text === "Next") {
        if (prevent[0].textContent !== "3") {
            prevent[0].nextElementSibling.classList.add("active");
            prevent[0].classList.remove("active");
            pageNumber = prevent[0].nextElementSibling.textContent;
        } else {
            pageNumber = prevent[0].textContent;
        }
    } else if (number[0].text === "Previous") {
        if (prevent[0].textContent !== "1") {
            prevent[0].previousElementSibling.classList.add("active");
            prevent[0].classList.remove("active");
            pageNumber = prevent[0].previousElementSibling.textContent;
        } else {
            pageNumber = prevent[0].textContent;
        }
    } else {
        prevent[0].classList.remove("active");
        page[0].classList.add("active");
        pageNumber = page[0].textContent;
    }
    $.post('/users', {
            page: pageNumber,
            id: 1,
        }, function (data) {
            parsing(data);
        }
    );
    event.preventDefault();
});

function parsing(data) {
    try {
        var pagination = document.getElementById("pagination");
        var result = document.getElementById("result");
        result.remove();
        var div = document.createElement("div");
        div.classList.add("mt-0");
        div.classList.add("mb-3");
        div.classList.add("p-3");
        div.classList.add("pt-1");
        div.classList.add("bg-body");
        div.classList.add("rounded");
        div.classList.add("shadow-sm");
        div.id = "result";
        if (data[0].length >= 1) {
            for (var i = 0; i < data[0].length; i++) {
                var a = document.createElement('a');
                a.classList.add('d-flex');
                a.classList.add('btn-outline-light');
                a.classList.add('text-dark');
                a.classList.add('border-bottom');
                a.classList.add('p-2');
                a.classList.add('pt-3');
                a.href = "<?php echo $this->url('profile', ['action' => 'profile', 'id' => $user['id']])?>";
                var img = document.createElement('img');
                img.classList.add('rounded');
                img.classList.add('dialogPict');
                img.classList.add('me-2');
                img.src = data[0][i]['photo'];
                var userName1 = document.createElement('p');
                userName1.classList.add("mb-0");
                userName1.classList.add("mt-1");
                var userName2 = document.createElement('strong');
                userName2.classList.add("d-block");
                userName2.classList.add("text-gray-dark");
                userName2.textContent = data[0][i]['lastname'] + " " + data[0][i]['firstname'];
                var online1 = document.createElement("p");
                online1.classList.add("ms-auto");
                online1.classList.add("mb-0");
                var online2 = document.createElement("strong");
                online2.classList.add("d-block");
                if (data[0][i]["is_online"] === "1") {
                    online2.classList.add("text-success");
                    online2.textContent = "Online";
                } else {
                    online2.classList.add("text-danger");
                    online2.textContent = "Offline";
                }
                userName1.append(userName2);
                online1.append(online2);
                a.append(img, userName1, online1);
                div.append(a);
            }
            pagination.before(div);
        } else {
            throw new Error("Users not found :(");
        }
    } catch (e) {
        let div = document.createElement("div");
        div.classList.add("text-center");
        div.classList.add("mt-3");
        div.id = "result";
        var h = document.createElement("h4");
        h.classList.add("text-gray");
        h.textContent = e.message;
        div.append(h);
        pagination.before(div);
    }
}
$("form").submit(function (event) {
    var searchLineValue = document.getElementsByName('search')[0].value;
    var genderValue = document.getElementsByName('dropdownGender')[0].value;
    var postValue = document.getElementsByName('dropdownPost')[0].value;
    var dateValues = document.getElementsByName('date[]');
    var dobBefore = dateValues[0].value;
    var dobAfter = dateValues[1].value;

    $.post('/messages', {
        searchLine: searchLineValue,
        gender: genderValue,
        post: postValue,
        dobBefore: dobBefore,
        dobAfter: dobAfter,
        id: 0,
    }, function (filteredData) {
        console.log(filteredData)
        $.post('/viewFilteredData', {
            id: 3,
            page: 1,
        }, function (data) {
            console.log(data)
            if (filteredData[0].length !== 0 && data[0].length !== 0) {
                let h5 = document.getElementsByTagName("h5")[0];
                if (document.getElementById("existDialogs") !== null)
                    document.getElementById("existDialogs").remove();
                var existDialog = document.createElement('div');
                existDialog.id = "existDialogs";
                for (let i = 0; i < data[0].length; i++) {
                    for (let j = 0; j < filteredData[0].length; j++) {
                        if (filteredData[0][j]["staffs.id"] === data[0][i]["staffs.id"]) {
                            let a = document.createElement("a");
                            a.classList.add("list-group-item");
                            a.classList.add("list-group-item-action");
                            a.classList.add("py-3");
                            a.classList.add("lh-sm");
                            a.href = "/chat/" + data[4][i]["companion"].toString();
                            let img = document.createElement('img');
                            img.classList.add('rounded');
                            img.classList.add('dialogPict');
                            img.classList.add('me-2');
                            img.src = data[2][i]["photo"];
                            let div = document.createElement("div");
                            div.classList.add("d-flex");
                            let div1 = document.createElement("div");
                            div1.classList.add("d-flex");
                            div1.classList.add("w-100");
                            div1.classList.add("align-items-center");
                            div1.classList.add("justify-content-between");
                            let strong = document.createElement("strong");
                            strong.classList.add("mb-1");
                            strong.textContent = data[4][i]["companionLastName"].toString() + " "
                                + data[4][i]["companionFirstName"].toString();
                            let small = document.createElement("small");
                            small.classList.add("text-muted");
                            small.textContent = data[4][i]["send_at"];
                            let div2 = document.createElement("div");
                            div2.classList.add("col-10");
                            div2.classList.add("small");
                            if (data[4][i]["companionLastName"] !== data[4][i]["id_send"]) {
                                let strong1 = document.createElement("strong");
                                strong1.textContent = "You";
                                div2.append(strong1);
                            }
                            div2.textContent = data[4][i]["letter"];
                            div1.append(strong);
                            div1.append(small);
                            div.append(img);
                            div.append(div1);
                            a.append(div);
                            a.append(div2)
                            existDialog.append(a);
                        }
                    }
                }
                h5.before(existDialog);
            }
            if (filteredData[0].length !== 0 && data[1].length !== 0) {
                if (document.getElementById("notExistDialogs") !== null)
                    document.getElementById("notExistDialogs").remove();
                var notExistDialog = document.createElement('div');
                notExistDialog.id = "notExistDialogs";
                for (let i = 0; i < data[1].length; i++) {
                    for (let j = 0; j < filteredData[0].length; j++) {
                        if (filteredData[0][j]["staffs.id"] === data[1][i]["id"]) {
                            let div = document.createElement("div");
                            div.classList.add("list-group-item");
                            div.classList.add("list-group-item-action");
                            div.classList.add("py-3");
                            div.classList.add("lh-sm");
                            let a = document.createElement("a");
                            a.classList.add("btn");
                            a.classList.add("btn-primary");
                            a.href = "/chat/" + data[1][i]["id"].toString();
                            a.textContent = "Write";
                            let img = document.createElement('img');
                            img.classList.add('rounded');
                            img.classList.add('dialogPict');
                            img.classList.add('me-2');
                            img.src = data[1][i]["photo"];
                            let div1 = document.createElement("div");
                            div1.classList.add("d-flex");
                            let div2 = document.createElement("div");
                            div2.classList.add("d-flex");
                            div2.classList.add("w-100");
                            div2.classList.add("align-items-center");
                            div2.classList.add("justify-content-between");
                            let strong = document.createElement("strong");
                            strong.classList.add("mb-1");
                            strong.textContent = data[1][i]["lastname"].toString() + " "
                                + data[1][i]["firstname"].toString();
                            div2.append(strong);
                            div1.append(img);
                            div1.append(div2);
                            div.append(div1);
                            div1.append(a);
                            notExistDialog.append(div);
                        }
                    }
                }
                document.getElementById("result").append(notExistDialog);
            }
            if (filteredData[0].length === 0) {
                if (document.getElementById("existDialogs") !== null &&
                    document.getElementById("notExistDialogs") !== null) {
                    let h5 = document.createElement("h5");
                    h5.classList.add("text-secondary");
                    h5.classList.add("mx-auto");
                    h5.classList.add("mt-3");
                    h5.textContent = "Users not found :("
                    document.getElementById("existDialogs").remove();
                    document.getElementById("notExistDialogs").remove();
                    document.getElementsByTagName("h5")[0].remove();
                    document.getElementById("result").append(h5);
                }
            }
        });
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
    $.post('/viewFilteredData', {
            page: pageNumber,
        }, function (data) {
            if (data[1].length !== 0) {
                var notExistDialog = document.createElement('div');
                notExistDialog.id = "notExistDialogs";
                if (document.getElementById("notExistDialogs") !== null)
                    document.getElementById("notExistDialogs").remove();
                for (let i = 0; i < data[1].length; i++) {
                    let div = document.createElement("div");
                    div.classList.add("list-group-item");
                    div.classList.add("list-group-item-action");
                    div.classList.add("py-3");
                    div.classList.add("lh-sm");
                    let a = document.createElement("a");
                    a.classList.add("btn");
                    a.classList.add("btn-primary");
                    a.href = "/chat/" + data[1][i]["id"].toString();
                    a.textContent = "Write";
                    let img = document.createElement('img');
                    img.classList.add('rounded');
                    img.classList.add('dialogPict');
                    img.classList.add('me-2');
                    img.src = data[1][i]["photo"];
                    let div1 = document.createElement("div");
                    div1.classList.add("d-flex");
                    let div2 = document.createElement("div");
                    div2.classList.add("d-flex");
                    div2.classList.add("w-100");
                    div2.classList.add("align-items-center");
                    div2.classList.add("justify-content-between");
                    let strong = document.createElement("strong");
                    strong.classList.add("mb-1");
                    strong.textContent = data[1][i]["lastname"].toString() + " "
                        + data[1][i]["firstname"].toString();
                    div2.append(strong);
                    div1.append(img);
                    div1.append(div2);
                    div.append(div1);
                    div1.append(a);
                    notExistDialog.append(div);
                }
                document.getElementsByTagName("h5")[0].after(notExistDialog);
            }
            for (let j = 0; j < data[0].length; j++) {
                    if (document.getElementById("existDialogs") !== null)
                        document.getElementById("existDialogs").remove();
                    var existDialog = document.createElement('div');
                    existDialog.id = "existDialogs";
                    for (let i = 0; i < data[4].length; i++) {
                        let a = document.createElement("a");
                        a.classList.add("list-group-item");
                        a.classList.add("list-group-item-action");
                        a.classList.add("py-3");
                        a.classList.add("lh-sm");
                        a.href = "/chat/" + data[4][i]["companion"].toString();
                        let img = document.createElement('img');
                        img.classList.add('rounded');
                        img.classList.add('dialogPict');
                        img.classList.add('me-2');
                        img.src = data[0][i]["photo"];
                        let div = document.createElement("div");
                        div.classList.add("d-flex");
                        let div1 = document.createElement("div");
                        div1.classList.add("d-flex");
                        div1.classList.add("w-100");
                        div1.classList.add("align-items-center");
                        div1.classList.add("justify-content-between");
                        let strong = document.createElement("strong");
                        strong.classList.add("mb-1");
                        strong.textContent = data[4][i]["companionLastName"].toString() + " "
                            + data[4][i]["companionFirstName"].toString();
                        let small = document.createElement("small");
                        small.classList.add("text-muted");
                        let d = new Date(data[4][i]["send_at"]);
                        let day = d.getDay() + 1;
                        let month = d.getMonth() + 1;
                        let hour = d.getHours();
                        let minute = d.getMinutes();
                        small.textContent = day + "." + month + " " + hour + ":" + minute;
                        let div2 = document.createElement("div");
                        div2.classList.add("col-10");
                        div2.classList.add("small");
                        div2.classList.add("mt-1");
                        if (data[4][i]["companion"] !== data[4][i]["id_send"]) {
                            div2.innerHTML = '<strong>You: </strong>' + data[4][i]["letter"];
                        } else {
                            div2.innerHTML = data[4][i]["letter"];
                        }
                        div1.append(strong);
                        div1.append(small);
                        div.append(img);
                        div.append(div1);
                        a.append(div);
                        a.append(div2)
                        existDialog.append(a);
                    }
                    document.getElementsByTagName("h5")[0].before(existDialog);
            }
        }
    );
    event.preventDefault();
});
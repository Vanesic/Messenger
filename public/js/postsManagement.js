var editPostNameOld;
window.onload = function (event) {
    var deleteButton = document.getElementsByName("deletePost[]");
    var editButton = document.getElementsByName("editButton[]");
    for (let i = 0; i < editButton.length; i++) {
        editButton[i].addEventListener("click", function (event) {
            var editPostName = editButton[i].parentElement.parentElement.getElementsByTagName("strong")[0].textContent;
            editPostNameOld = editPostName;
            editButton[i].parentElement.parentElement.getElementsByTagName("strong")[0].remove();
            var input = document.createElement("input");
            input.value = editPostName;
            input.name = "editInput";
            input.required = true;
            editButton[i].parentElement.parentElement.getElementsByTagName("p")[0].append(input);
            editButton[i].remove();
            var buttonSave = document.createElement("button");
            buttonSave.textContent = "Save";
            buttonSave.classList.add("btn");
            buttonSave.classList.add("btn-outline-primary");
            buttonSave.classList.add("mb-1");
            buttonSave.classList.add("ms-auto");
            buttonSave.classList.add("me-1");
            buttonSave.type = "button";
            buttonSave.id = "savePost";
            deleteButton[i].disabled = true;
            deleteButton[i].before(buttonSave);
            buttonSave.addEventListener("click", savePost)
            event.preventDefault();
        })
    }
    for (let i = 0; i < deleteButton.length; i++) {
        deleteButton[i].addEventListener("click", function () {
            var deletePostName = deleteButton[i].parentElement.parentElement.getElementsByTagName("strong")[0].textContent;
            $.post('/deletePost', {
                postName: deletePostName,
                id: 0,
            }, function () {
                deleteButton[i].parentElement.parentElement.remove();
            });
        })
    }
    event.preventDefault();
}

$("#addPostButton").click(function (event) {
    var postName = document.getElementsByName("post")[0].value;
    if (postName !== "") {
        $.post('/insertPost', {
                postName: postName,
                id: 1,
            }, function (data) {
               parsing(data);
            }
        )
    }
    event.preventDefault();
});

var parsing = function (data){
    document.getElementById("delete").remove();
    var div = document.createElement("div");
    div.id = "delete";
    for (let i = 0; i < data[0].length; i++) {
        var div1 = document.createElement("div");
        div1.classList.add("mt-0");
        div1.classList.add("pt-1");
        div1.classList.add("bg-light");
        div1.classList.add("rounded");
        div1.classList.add("shadow-sm");
        var div2 = document.createElement("div");
        div2.classList.add("d-flex");
        div2.classList.add("text-dark");
        div2.classList.add("border-bottom");
        div2.classList.add("p-2");
        div2.classList.add("pt-3");
        var div3 = document.createElement("div");
        div3.classList.add("ms-auto");
        var p = document.createElement("p");
        p.classList.add("mb-0");
        p.classList.add("p-1");
        var strong = document.createElement("strong");
        strong.classList.add("d-block");
        strong.classList.add("text-gray-dark");
        strong.textContent = data[0][i]["name_post"];
        var deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.classList.add("btn");
        deleteButton.classList.add("btn-outline-danger");
        deleteButton.classList.add("mb-1");
        deleteButton.classList.add("ms-auto");
        deleteButton.name = "deletePost[]";
        deleteButton.textContent = "Delete";
        var editButton = document.createElement("button");
        editButton.type = "button";
        editButton.classList.add("btn");
        editButton.classList.add("btn-outline-primary");
        editButton.classList.add("mb-1");
        editButton.classList.add("me-1");
        editButton.classList.add("ms-auto");
        editButton.classList.add("bg-white");
        editButton.name = "editButton[]";
        var img = document.createElement("img");
        img.classList.add("reductPict");
        img.src = "/img/reduct.svg";
        editButton.append(img);
        div3.append(editButton);
        div3.append(deleteButton);
        p.append(strong);
        div2.append(p);
        div2.append(div3);
        div1.append(div2);
        div.append(div1);
    }
    var postList = document.getElementById("postsList");
    postList.append(div);
}

var savePost = function (event) {
    var editInput = document.getElementsByName("editInput")[0];
    if (editInput.value !== "") {
        var postNameNew = editInput.value;
        $.post('/editPost', {
            postNameNew: postNameNew,
            postNameOld: editPostNameOld,
            id: 2,
        }, function (data) {
           parsing(data);
        })
        event.preventDefault();
    }
}

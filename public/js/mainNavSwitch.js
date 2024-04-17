var i = window.location.pathname;
i = i.replace(/[0-9]/g,"");
if (i === "/users" || i === "admin/users"){
    let previous = document.getElementById("mainNav").querySelector(".active");
    previous.classList.remove("active");
    let nowPage = document.getElementById("users");
    nowPage.classList.add("active");
}
if (i === "/messages" ||
    i === "admin/messages" ||
    i === "/chat/"
) {
    let previous = document.getElementById("mainNav").querySelector(".active");
    previous.classList.remove("active");
    let nowPage = document.getElementById("messages");
    nowPage.classList.add("active");
}
if (i === "/edit" || i === "admin/edit/"){
    let previous = document.getElementById("mainNav").querySelector(".active");
    previous.classList.remove("active");
    let nowPage = document.getElementById("profile");
    nowPage.classList.add("active");
}
if (i === "/settings" || i === "admin/settings"){
    let previous = document.getElementById("mainNav").querySelector(".active");
    previous.classList.remove("active");
    let nowPage = document.getElementById("settings");
    nowPage.classList.add("active");
}

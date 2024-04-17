$("form").submit(function (event) {
    var message = document.getElementsByName('message')[0].value;
    var userId = window.location.pathname;
    userId = userId.split("/chat");
    $.post('/chat'+userId[1], {
        message: message,
        id: 0,
    }, function () {
        document.getElementsByName('message')[0].value = "";
    })
    event.preventDefault();
})

$("#load").click(function (event){
    var userId = window.location.pathname;
    var iteration =  $(this)[0].name;
    $.post(userId, {
        iteration: iteration,
        id: 1,
    }, function (data) {
        let iteration = document.getElementById("load").name;
        iteration = Number(iteration)+1;
        document.getElementById("load").name = iteration;
        for (let i=data[0].length-1; i>=0; i--){
            if (data[0][i]["id_get"] === "3"){
                let div = document.createElement("div");
                div.classList.add('d-flex');
                div.classList.add('w-50');
                div.classList.add('rounded-3');
                div.classList.add('mt-4');
                div.classList.add('m-2');
                div.classList.add('p-1');
                div.classList.add('sender');
                let date = new Date(data[0][i]["send_at"]);
                let hour = date.getHours();
                let minutes = date.getMinutes();
                console.log();
                div.innerHTML = '<img src="'+data[2]["photo"]+'" class="dialogPict rounded"> <h6 class="ms-2 fw-bolder my-auto">' + data[0][i]["letter"] + '</h6> <span class="ms-auto small">' +hour+":"+minutes+'</span>'
                   document.getElementById("load").after(div);
            }else{
                let div = document.createElement("div");
                div.classList.add('d-flex');
                div.classList.add('ms-auto');
                div.classList.add('rounded-3');
                div.classList.add('mt-4');
                div.classList.add('w-50');
                div.classList.add('p-1');
                div.classList.add('m-2');
                div.classList.add('getter');
                let date = new Date(data[0][i]["send_at"]);
                let hour = date.getHours();
                let minutes = date.getMinutes();
                div.innerHTML = '<img src="'+data[1]["photo"]+'" class="dialogPict rounded" alt="Avatar"><h6 class="ms-2 fw-bolder my-auto">' + data[0][i]["letter"] + '</h6> <span class="ms-auto small">' +hour+":"+minutes+'</span>'
                document.getElementById("load").after(div);
            }
        }
    })
    event.preventDefault();
})
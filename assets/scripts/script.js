document.addEventListener("DOMContentLoaded", function(){
    let socket = new WebSocket("ws://localhost:889/chat/server.php");
    let blockMessage = "chat__result";

    socket.onerror = function(error) {
        message("<div class='block-error'>"+ "Ошибка при присоединени" +"</div>");
    };

    socket.onopen = function () {
        message( "<div class='block-success'>Соединение установлено.</div>");
    }

    socket.onclose = function(event) {
        message("<div class='block-error'>"+"Соединение закрыто"+"</div>");
    };

    socket.onmessage = function(event) {
        let data = JSON.parse(event.data);
        message("<div class='block-info'>"+ data.type + "-" +data.message + "</div>");
    };



});

function message(text, block = 'chat__result') {
    try {
        document.getElementById(block).innerHTML = text;
    } catch (e) {
        alert(e);
    }
}
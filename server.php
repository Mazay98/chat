<?php
    define('PORT', '889');
    define('HOST_NAME', 'localhost/chat');

    require_once "controllers\ChatController.php";

    $chat = new Chat();

    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
    socket_bind($socket, '127.0.0.1', PORT);

    socket_listen($socket);

    while (true) {
        $newSocket = socket_accept($socket);
        $header = socket_read($newSocket, 1024);

        $chat->sendHeaders($header, $newSocket, HOST_NAME, PORT);
    }

    socket_close($socket);
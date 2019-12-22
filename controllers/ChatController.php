<?php

class Chat
{
    public function sendHeaders($headersText, $newSocket, $host, $port)
    {
        $headers = [];
        $tmpLine = preg_split('/\r\n/', $headersText);

        foreach ($tmpLine as $line) {
            $line = rtrim($line);
            if (preg_match('/\A(\S+):\s?(.*)\z/', $line, $matches)) {
                $headers[$matches[1]] = $matches[2];
            }
        }
        $key = $headers['Sec-WebSocket-Key'];
        $sKey = base64_encode(pack('H*', sha1($key.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));

        $strHeader = "HTTP/1.1 101 Switching Protocols\r\n";
        $strHeader .= "Upgrade: websocket\r\n";
        $strHeader .= "Connection: Upgrade\r\n";
        $strHeader .= "WebSocket-Origin: $host\r\n";
        $strHeader .= "WebSocket-Location: ws://$host:$port/server.php\r\n";
        $strHeader .= "Sec-WebSocket-Accept: $sKey\r\n";

        socket_write($newSocket, $strHeader. strlen($strHeader));
    }
}
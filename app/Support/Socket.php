<?php namespace App\Support;

class Socket {
    private $socket;

    public function __construct()
    {
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
    }

    public function write($message)
    {
        $portal_server_host = env('PORTAL_SERVER_HOST', '127.0.0.1');
        $portal_server_port = env('PORTAL_SERVER_PORT', '3358');
        socket_sendto($this->socket, $message, strlen($message), 0, $portal_server_host, $portal_server_port);

        $buffer = "";
        $from = "";
        $port = "";
        socket_recvfrom($this->socket, $buffer, 1024, 0, $from, $port);
        echo $buffer;
    }
}

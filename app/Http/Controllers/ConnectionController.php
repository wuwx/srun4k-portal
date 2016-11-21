<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    private $_porta_server_ip;
    private $_portal_server_port;

    public function __construct()
    {
        $this->_porta_server_ip = '127.0.0.1';
        $this->_porta_server_port = 3358;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(ConnectionRequest $request)
    {
        $buffer = "";
        $from = "";
        $port = "";
        $array = [
            'action' => 1,
            'serial_code' => time().rand(111111,999999),
            'time' => time(),
            'user_name' => $request->user_name,
            'user_password' => $request->user_password,
            'user_ip' => $request->ip(),
            'ac_id' => "1",
        ];
        $json = json_encode($array);

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_sendto($socket, $json, strlen($json), 0, $this->_porta_server_ip, $this->_porta_server_port);
        socket_recvfrom($socket, $buffer,1024, 0, $from, $port);

        return view('connection.create');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('connection.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $buffer = "";
        $from = "";
        $port = "";
        $array = [
            "action" => 2,
            'serial_code' => time().rand(111111,999999),
            'time' => time(),
            'user_ip' => $request->ip(),
        ];

        $json = json_encode($array);

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_sendto($socket, $json, strlen($json), 0, $this->_porta_server_ip, $this->_porta_server_port);
        socket_recvfrom($socket, $buffer,1024, 0, $from, $port);

        return view('connection.destroy');
    }
}

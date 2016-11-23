<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Http\Requests\ConnectionRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class ConnectionController extends Controller
{
    private $portalServerHost;
    private $portalServerPort;

    public function __construct()
    {
        $this->portalServerHost = env('PORTAL_SERVER_HOST', '127.0.0.1');
        $this->portalServerPort = env('PORTAL_SERVER_PORT', '3358');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConnectionRequest $request)
    {
        $buffer = "";
        $from = "";
        $port = "";
        $array = [
            'action' => 1,
            'serial_code' => time() . rand(111111, 999999),
            'time' => time(),
            'user_name' => $request->user_name,
            'user_password' => $request->user_password,
            'user_ip' => $request->ip(),
            'ac_id' => "1",
        ];
        $json = json_encode($array);

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 2, "usec" => 0));
        socket_sendto($socket, $json, strlen($json), 0, $this->portalServerHost, $this->portalServerPort);
        socket_recvfrom($socket, $buffer, 1024, 0, $from, $port);

        $connection = Connection::findByUserIP($request->ip());
        switch($request->format()) {
            case 'js':
                return Response::make(view('connection.store', compact('connection')), 201, [
                    'Content-Type' => "application/javascript; charset=UTF-8",
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $connection = Connection::findByUserIP(Request::ip());
        return view('connection.show', compact('connection'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        switch (Request::query('action')) {
            case 2:
                return $this->destroyByUserIP();
            case 3:
                return $this->destroyByUserName();
        }
    }

    public function destroyByUserName()
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));

        $buffer = "";
        $from = "";
        $port = "";

        $array = [
            "action" => 3,
            'serial_code' => time().rand(111111,999999),
            'time' => time(),
            'user_name' => Request::query('user_name'),
            'user_password' => Request::query('user_password'),
        ];
        $json = json_encode($array);
        socket_sendto($socket, $json, strlen($json), 0, $this->portalServerHost, $this->portalServerPort);
        socket_recvfrom($socket, $buffer, 1024, 0, $from, $port);

        return view('connection.destroy');
    }

    public function destroyByUserIP()
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));

        $buffer = "";
        $from = "";
        $port = "";

        $array = [
            "action" => 2,
            'serial_code' => time() . rand(111111, 999999),
            'time' => time(),
            'user_ip' => Request::ip(),
        ];
        $json = json_encode($array);
        socket_sendto($socket, $json, strlen($json), 0, $this->portalServerHost, $this->portalServerPort);
        socket_recvfrom($socket, $buffer, 1024, 0, $from, $port);

        switch(Request::format()) {
            case 'js':
                return Response::make(view('connection.destroy'), 200, [
                    'Content-Type' => "application/javascript; charset=UTF-8",
                ]);
            case 'html':
                return view('connection.destroy');
        }

    }
}

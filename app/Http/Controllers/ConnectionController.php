<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class ConnectionController extends Controller
{
    private $portalServerHost;
    private $portalServerPort;

    public function __construct()
    {
        $this->portalServerHost = '127.0.0.1';
        $this->portalServerPort = 3358;
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

        switch($request->format()) {
            case 'js':
                return Response::make(view('connection.create'), 201, [
                    'Content-Type' => "application/javascript; charset=UTF-8",
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $connection = Connection::findByUserIP($request->ip());
        if ($json = Cache::get('json')) {
            return json_decode($json)->posts[0]->title;
        } else {
            return view('connection.show');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        switch ($request->action) {
            case 2:
                return $this->destroyByUserIP($request);
            case 3:
                return $this->destroyByUserIP($request);
        }
    }

    public function destroyByUserName(Request $request)
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
            'user_name' => $request->user_name,
            'user_password' => $request->user_password,
        ];
        $json = json_encode($array);
        socket_sendto($socket, $json, strlen($json), 0, $this->portalServerHost, $this->portalServerPort);
        socket_recvfrom($socket, $buffer, 1024, 0, $from, $port);

        return view('connection.destroy');
    }

    public function destroyByUserIP(Request $request)
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
            'user_ip' => $request->ip(),
        ];
        $json = json_encode($array);
        socket_sendto($socket, $json, strlen($json), 0, $this->portalServerHost, $this->portalServerPort);
        socket_recvfrom($socket, $buffer, 1024, 0, $from, $port);

        switch($request->format()) {
            case 'js':
                return Response::make(view('connection.destroy'), 200, [
                    'Content-Type' => "application/javascript; charset=UTF-8",
                ]);
            case 'html':
                return view('connection.destroy');
        }

    }
}

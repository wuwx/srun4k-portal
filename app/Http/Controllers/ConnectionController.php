<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Http\Requests\ConnectionRequest;
use App\Support\Socket;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ConnectionController extends Controller
{
    private $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ConnectionRequest $request)
    {
        $array = [
            'serial_code'   => time().rand(111111, 999999),
            'time'          => time(),
            'action'        => 1,
            'user_name'     => $request->user_name,
            'user_password' => $request->user_password,
            'user_ip'       => $request->ip(),
            'ac_id'         => '1',
        ];
        $json = json_encode($array);
        $this->socket->write($json);

        $connection = Connection::findByUserIP($request->ip());
        switch ($request->format()) {
            case 'js':
                return Response::make(view('connection.store', compact('connection')), 201, [
                    'Content-Type' => 'application/javascript; charset=UTF-8',
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
        switch (Request::input('action')) {
            case 2:
                return $this->destroyByUserIP();
            case 3:
                return $this->destroyByUserName();
        }
    }

    public function destroyByUserName()
    {
        $array = [
            'serial_code'   => time().rand(111111, 999999),
            'time'          => time(),
            'action'        => 3,
            'user_name'     => Request::input('user_name'),
            'user_password' => Request::input('user_password'),
        ];
        $json = json_encode($array);
        $this->socket->write($json);

        switch (Request::format()) {
            case 'js':
                return Response::make(view('connection.destroy'), 200, [
                    'Content-Type' => 'application/javascript; charset=UTF-8',
                ]);
            case 'html':
                return view('connection.destroy');
        }
    }

    public function destroyByUserIP()
    {
        $array = [
            'serial_code' => time().rand(111111, 999999),
            'time'        => time(),
            'action'      => 2,
            'user_ip'     => Request::ip(),
        ];
        $json = json_encode($array);
        $this->socket->write($json);

        switch (Request::format()) {
            case 'js':
                return Response::make(view('connection.destroy'), 200, [
                    'Content-Type' => 'application/javascript; charset=UTF-8',
                ]);
            case 'html':
                return view('connection.destroy');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(ConnectionRequest $request)
    {
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
        return view('connection.destroy');
    }
}

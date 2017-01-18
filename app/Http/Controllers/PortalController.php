<?php

namespace App\Http\Controllers;

class PortalController extends Controller
{
    public function __invoke()
    {
        return view('portal');
    }
}

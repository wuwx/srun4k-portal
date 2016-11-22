<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        switch($request->format()) {
            case "html":
                return "";
            case "json":
                $json = file_get_contents("http://network.neu.edu.cn/api/get_recent_posts/");
                return Response::make($json, 200, [
                    'Content-Type' => "application/json; charset=UTF-8",
                ]);
        }

    }
}

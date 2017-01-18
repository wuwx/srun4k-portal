<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->format()) {
            case 'html':
                return '';
            case 'json':
                if (!$json = Cache::get('json')) {
                    $json = file_get_contents('http://network.neu.edu.cn/api/get_recent_posts/');
                    Cache::put('json', $json, 10);
                }

                return Response::make($json, 200, [
                    'Content-Type' => 'application/json; charset=UTF-8',
                ]);
        }
    }
}

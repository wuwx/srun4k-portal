<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Connection
{
    public static function findByUserIP($user_ip)
    {
        $online_id = Redis::get("key:rad_online:ip:$user_ip:0");
        $connection = Redis::hGetAll("hash:rad_online:$online_id");

        return $connection;
    }
}

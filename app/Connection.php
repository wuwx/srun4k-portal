<?php namespace App;

use Illuminate\Support\Facades\Redis;

class Connection
{
    public static function findByUserIP($user_ip)
    {
        $connection_id = Redis::get("key:rad_online:ip:$user_ip:0");
        $connection = Redis::hGetAll("hash:rad_online:$connection_id");
        return $connection;
    }
}

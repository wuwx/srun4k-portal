<?php namespace App;

class Connection
{
    public $user_ip;
    public $user_name;

    public static function findByUserIP($user_ip)
    {
        return new self;
    }
}

<?php

namespace BankBundle\Service;

use Redis ;

class RedisClient extends Controller
{
    public function __construct(Redis $sncRedisDefault)
    {
        $this->client    = $sncRedisDefault;
    }
    
    public function clientRedis(){
            return $this->client;
    }
}

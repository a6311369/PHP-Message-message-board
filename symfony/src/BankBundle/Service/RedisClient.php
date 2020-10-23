<?php

namespace BankBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedisClient extends Controller
{

    private $redis;

    public function __construct()
    {
        $redis = $this->container;
        var_dump($redis);exit;
    }

    public function getAccountId($keys)
    {
        // $redis = $this->container->get('snc_redis.default');
        $AccountId = $this->redis->GET($keys);
        // $AccountId = $redis->GET($keys);
        // $AccountId = $keys;
        var_dump($AccountId);
        return $AccountId;
    }
}

<?php

namespace BankBundle\Service;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedisClient
{
  private $host = '127.0.0.1';

  private $client;


  public function __construct()
  {
    $this->connect();
  }

  public function connect()
  {
    $this->client = new Client([
      'scheme' => 'tcp',
      'host' => $this->host,
    ]);
    return $this;
  }

  public function getAccountId($id)
  {
    $redis = $this->client;
    if ($redis->KEYS('accountId' . $id) == null) {
      return true;
    };
  }
  public function setBankMoney($accountId, $bankMoney)
  {
    $redis = $this->client;
    $redis->SET('accountId' . $accountId, $bankMoney);
    $redis->LPUSH('id', $accountId);
  }

  public function getBankMoney($bankUser)
  {
    $redis = $this->client;
    $bankMoney = $redis->GET($bankUser);
    return $bankMoney;
  }

  public function setTotalMoney($bankUser, $totalMoney)
  {
    $redis = $this->client;
    $redis->SET($bankUser, $totalMoney);
  }

  public function countModNum($id)
  {
    $redis = $this->client;
    $num = $redis->GET('detailNum:Id:' . $id);
    if ($num == 0) {
      $redis->SET('detailNum:Id:' . $id, 1);
    } else {
      $redis->INCR('detailNum:Id:' . $id);
    }
  }
}

<?php

namespace BankBundle\Service;

use Predis\Client;

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

  //判斷Redis內有無key值
  public function getAccountId($id)
  {
    $redis = $this->client;
    if ($redis->KEYS('accountId' . $id) == null) {
      return true;
    };
  }
  //將餘額存入Redis
  public function setBankMoney($accountId, $bankMoney)
  {
    $redis = $this->client;
    $redis->SET('accountId' . $accountId, $bankMoney);
    $redis->LPUSH('id', $accountId);
  }

  //獲取Redis內餘額
  public function getBankMoney($bankUser)
  {
    $redis = $this->client;
    $bankMoney = $redis->GET($bankUser);
    return $bankMoney;
  }

  //更新餘額
  public function setTotalMoney($bankUser, $totalMoney)
  {
    $redis = $this->client;
    $redis->SET($bankUser, $totalMoney);
  }

  //計算修改幾次，要寫入明細檔時用的迴圈圈數
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
  
  //明細Redis
  public function writeDetail($id, $notes, $depositMoney, $balance, $totalMoney, $datetime)
  {
    $redis = $this->client;
    $redis->LPUSH('detailNotes:Id:' . $id, $notes);
    $redis->SET('detailID:' . $id, $id);
    $redis->LPUSH('detailModmoney:Id:' . $id, $depositMoney);
    $redis->LPUSH('detailOldmoney:Id:' . $id, $balance);
    $redis->LPUSH('detailNewmoney:Id:' . $id, $totalMoney);
    $redis->LPUSH('detaildate:Id:' . $id, $datetime);
  }
}

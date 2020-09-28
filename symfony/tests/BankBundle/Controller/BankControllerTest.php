<?php

// tests/BankBundle/Controller/BankControllerTest.php
namespace Tests\BankBundle\Controller;

use BankBundle\Controller\BankController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use BankBundle\Entity\Bank;



class BankControllerTest extends WebTestCase
{
  public function testDepositPost()
  {
    $client = static::createClient();
    $client->request('POST', '/bank/deposit', ['id' => '1', 'depositMoney' => '50']);

    var_dump($client);
    $this->assertEquals(
      200,
      $client->getResponse()->getStatusCode()
    );

    $client->insulate();
    $client->restart();
  }

  public function testWithdrawPost()
  {
    $client = static::createClient();
    $client->request('POST', '/bank/withdraw', ['id' => '1', 'depositMoney' => '50']);

    $this->assertEquals(
      200,
      $client->getResponse()->getStatusCode()
    );

    $client->insulate();
    $client->restart();
  }
}

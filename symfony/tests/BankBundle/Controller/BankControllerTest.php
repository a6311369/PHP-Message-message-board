<?php

// tests/BankBundle/Controller/BankControllerTest.php
namespace Tests\BankBundle\Controller;

use BankBundle\Controller\BankController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;
use BankBundle\Entity\Bank;
use BankBundle\Entity\BankDetail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;



class BankControllerTest extends WebTestCase
{
    public function testDeposit()
  {
    $client = static::createClient();
    $client->request('POST', '/bank/deposit', ['id' => '2', 'depositMoney' => '50']);


    $this->assertEquals(200,$client->getResponse()->getStatusCode());

    $client->insulate();
    $client->restart();
  }

   public function testWithdraw()
  {
    $client = static::createClient();
    $client->request('POST', '/bank/withdraw', ['id' => '2', 'withdrawMoney' => '50']);

    $this->assertEquals(200,$client->getResponse()->getStatusCode());

    $client->insulate();
    $client->restart();
  }
}

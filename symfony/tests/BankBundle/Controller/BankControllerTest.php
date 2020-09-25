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
            $this->assertJsonStringEqualsJsonString(
                json_encode(array("bankuUser" => "User0")), json_encode(array("bankuUser" => "User0"))
              );
            $client->insulate();
            $client->restart();
        }
        public function testWithdrawPost()
        {
            $client = static::createClient();
            $client->request('POST', '/bank/withdraw', ['id' => '1', 'depositMoney' => '50']);
            $this->assertJsonStringEqualsJsonString(
                json_encode(array("bankuUser" => "User0")), json_encode(array("bankuUser" => "User0"))
              );
            $client->insulate();
            $client->restart();
        }
}

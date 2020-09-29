<?php

// tests/BankBundle/Controller/BankControllerTest.php
namespace Tests\BankBundle\Controller;

use BankBundle\Controller\BankController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;
use BankBundle\Entity\Bank;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;



class BankControllerTest extends WebTestCase
{
  public function testDepositGetMoneyAndGetUser()
  {
    $bank = new Bank();
    $bank->setMoney(10000);
    $bank->setUser('QOO1');

    $bankRepository = $this->createMock(ObjectRepository::class);
    $bankRepository->expects($this->any())
      ->method('find')
      ->willReturn($bank);

    $objectManager = $this->createMock(ObjectManager::class);
    $objectManager->expects($this->any())
      ->method('getRepository')
      ->willReturn($bankRepository);

    $array = ['QOO1',10000];
    $BankController = new BankController($objectManager);
    $this->assertEquals($array, $BankController->depositAction(1));
  }

  public function testWithdrawGetMoneyAndGetUser()
  {
    $bank = new Bank();
    $bank->setMoney(500);
    $bank->setUser('QOO2');
    $bankRepository = $this->createMock(ObjectRepository::class);
    $bankRepository->expects($this->any())
      ->method('find')
      ->willReturn($bank);

    $objectManager = $this->createMock(ObjectManager::class);
    $objectManager->expects($this->any())
      ->method('getRepository')
      ->willReturn($bankRepository);

    $array = ['QOO2',500];
    $BankController = new BankController($objectManager);
    $this->assertEquals($array, $BankController->withdrawAction(1));
  }


  // public function testDepositPost()
  // {
  //   $client = static::createClient();
  //   $client->request('POST', '/bank/deposit', ['id' => '1', 'depositMoney' => '50']);


  //   $this->assertEquals(
  //     200,
  //     $client->getResponse()->getStatusCode()
  //   );

  //   $client->insulate();
  //   $client->restart();
  // }



  // public function testWithdrawPost()
  // {
  //   $client = static::createClient();
  //   $client->request('POST', '/bank/withdraw', ['id' => '1', 'depositMoney' => '50']);

  //   $this->assertEquals(
  //     200,
  //     $client->getResponse()->getStatusCode()
  //   );

  //   $client->insulate();
  //   $client->restart();
  // }


}

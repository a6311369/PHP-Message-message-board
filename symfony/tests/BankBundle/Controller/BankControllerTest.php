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
  public function testDepositPost()
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


    $array = ['QOO1', 11000];

    $BankController = new BankController($objectManager);
    $this->assertEquals($array, $BankController->depositAction(1, 1000));
  }

  public function testWithdrawPost()
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

    $array = ['QOO2', 500];
    $BankController = new BankController($objectManager);
    $this->assertEquals($array, $BankController->withdrawAction(1));
  }
}

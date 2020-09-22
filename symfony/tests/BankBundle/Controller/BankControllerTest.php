<?php

// tests/BankBundle/Controller/BankControllerTest.php
namespace Tests\BankBundle\Controller;

use BankBundle\Controller\BankController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use BankBundle\Entity\Bank;
use BankBundle\Entity\BankDetail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;



class BankControllerTest extends WebTestCase
{
    public function testDeposit()
    {
        $inBankMoney = 1000;
        $depositMoney = 500;
        $totalMoney = $depositMoney + $inBankMoney;
        $this->assertEquals(1500, $totalMoney);
    }

        public function testWithdraw()
        {
            $inBankMoney = 1000;
            $depositMoney = 500;
            $totalMoney = $inBankMoney - $depositMoney;
            $this->assertEquals(500, $totalMoney);
        }

        public function testDepositPost()
        {
            $client = static::createClient();
            $client->request('POST', '/bank/deposit', ['id' => '1', 'depositMoney' => '50']);
            $this->assertNotNull($client);
            $client->insulate();
        }

        public function testSetBank()
        {
            $bank = new Bank();
            $bank->setMoney(5000);
            $bank->setUser('QQ');
            $this->assertSame(5000, $bank->getMoney());
            $this->assertSame('QQ', $bank->getUser());
        }

        public function testSetBankdetail()
        {
            $bankDetail = new BankDetail();
            $bankDetail->setUser_id(123);
            $bankDetail->setNotes('提款');
            $this->assertSame(123, $bankDetail->getUser_id());
            $this->assertSame('提款', $bankDetail->getNotes());
        }



}

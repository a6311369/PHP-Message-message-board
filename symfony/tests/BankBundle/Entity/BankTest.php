<?php

// tests/BankBundle/Entity/BankTest.php
namespace Tests\BankBundle\Entity;

use BankBundle\Entity\Bank;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use BankBundle\Controller\BankController;


class BankEntityTest extends TestCase
{
    /**
     * 測試function setMoney
     * 測試function getMoney
     */
    public function testGetMoney()
    {
        $bank = new Bank();
        $bank->setMoney(5000);
        $this->assertEquals(5000, $bank->getMoney());
    }

    /**
     * 測試function setUser
     * 測試function getUser
     */
    public function testGetUser()
    {
        $bank = new Bank();
        $bank->setUser('User0');
        $this->assertEquals('User0', $bank->getUser());
    }

    /**
     * 測試function getId
     */
    public function testgetIdr()
    {
        $bank = new Bank();
        $this->assertEquals(1, $bank->getId());
    }
}

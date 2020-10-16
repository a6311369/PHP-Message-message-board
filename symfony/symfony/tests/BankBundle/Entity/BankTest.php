<?php

// tests/BankBundle/Entity/BankTest.php
namespace Tests\BankBundle\Entity;

use BankBundle\Entity\Bank;
use PHPUnit\Framework\TestCase;

class BankControllerTest extends TestCase
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
        $bank->setUser('QQ');
        $this->assertEquals('QQ', $bank->getUser());
    }
}
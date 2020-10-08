<?php

// tests/BankBundle/Entity/BankDetailTest.php
namespace Tests\BankBundle\Entity;

use BankBundle\Entity\BankDetail;
use PHPUnit\Framework\TestCase;

class BankDetailEntityTest extends TestCase
{
    /**
     * 測試function setUser_id
     * 測試function getUser_id
     */
    public function testGetUser_id()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setUserName('User0');
        $this->assertEquals('User0', $bankDetail->getUserName());
    }

    /**
     * 測試function setNotes
     * 測試function getNotes
     */
    public function testGetNotes()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setNotes('提款');
        $this->assertEquals('提款', $bankDetail->getNotes());
    }

    /**
     * 測試function setModifyMoney
     * 測試function getModifyMoney
     */
    public function testGetModifyMoney()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setModifyMoney(1000);
        $this->assertEquals(1000, $bankDetail->getModifyMoney());
    }

    /**
     * 測試function setOldMoney
     * 測試function getOldMoney
     */
    public function testGetOldMoney()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setOldMoney(1000);
        $this->assertEquals(1000, $bankDetail->getOldMoney());
    }

    /**
     * 測試function setNewMoney
     * 測試function getNewMoney
     */
    public function testGetNewMoney()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setNewMoney(1000);
        $this->assertEquals(1000, $bankDetail->getNewMoney());
    }

    /**
     * 測試function setCreatedTime
     * 測試function getCreatedTime
     */
    public function testGetCreatedTime()
    {
        $bankDetail = new BankDetail();
        $bankDetail->setCreatedTime('2020-10-08 14:36:10');
        $this->assertEquals('2020-10-08 14:36:10', $bankDetail->getCreatedTime());
    }
}

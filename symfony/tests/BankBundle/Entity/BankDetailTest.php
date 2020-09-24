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
        $bankDetail->setUser_id(123);
        $this->assertEquals(123, $bankDetail->getUser_id());
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
}

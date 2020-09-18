<?php

// tests/BankBundle/Controller/BankControllerTest.php
namespace Tests\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class BankControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $test = $client->request('POST', '/bank/deposit', array('id' => '1', 'depositMoney' => '100'));

        $this->assertContains('Q1',$test);

        // $this->assertTrue(
        //     $client->getResponse()->headers->contains(
        //         'Content-Type',
        //         'application/json'
        //     )
        // );        
    }
}

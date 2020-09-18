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
        // $client = static::createClient();
        $client = static::createClient([], [
            'HTTP_HOST' => 'tuffy.com:8000',
        ] );

        $client->request('POST', '/bank/withdraw', ['id' => '2', 'depositMoney' => '50']);

        $this->assertEquals(
            200, 
            $client->getResponse()->getStatusCode()
        );
        $client->insulate();

    }
}

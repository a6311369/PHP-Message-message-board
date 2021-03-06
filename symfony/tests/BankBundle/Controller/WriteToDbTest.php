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



class WriteToDbController extends WebTestCase
{
    public function testwriteToDb()
  {
        $client = static::createClient();
        $client->request('GET','/writetodb/writetodb');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $client->insulate();
    $client->restart();
  } 
}

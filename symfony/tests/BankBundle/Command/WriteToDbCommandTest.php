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
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;


class WriteToDbCommand extends KernelTestCase
{
  public function testExecute()
  {
    $kernel = static::createKernel();
    $application = new Application($kernel);

    $command = $application->find('app:writetodb');
    $commandTester = new CommandTester($command);
    $commandTester->execute([]);

    $output = $commandTester->getDisplay();
    $this->assertContains('', $output);

  }
}

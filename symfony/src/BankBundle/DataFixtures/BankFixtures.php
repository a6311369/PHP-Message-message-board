<?php

namespace BankBundle\DataFixtures;

use BankBundle\Entity\Bank;
use BankBundle\Entity\BankDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BankFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 5 bank date! Bam!
        for ($i = 0; $i < 5; $i++) {
            $bank = new Bank();
            $bank->setMoney(500000);
            $bank->setUser('User' . $i);
            $manager->persist($bank);
        }
        for ($i = 0; $i < 3; $i++) {
            $bank = new BankDetail();
            $bank->setUserName('User0');
            $bank->setNotes('存款');
            $manager->persist($bank);
        }
        for ($i = 0; $i < 3; $i++) {
            $bank = new BankDetail();
            $bank->setUserName('User0');
            $bank->setNotes('提款');
            $manager->persist($bank);
        }

        $manager->flush();
    }
}

<?php

namespace BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BankBundle\Entity\Bank;
use BankBundle\Entity\BankDetail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;


class WriteToDbController extends Controller
{

    /**
     * @Route("/writetodb/writetodb", name="writetodb"))
     */
    public function writeToDbAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');
        $bank = new Bank();
        $bankDetail = new BankDetail();

        $qb = $entityManager->createQueryBuilder();
        $qb->select('count(account.user)');
        $qb->from('BankBundle:Bank', 'account');
        $count = $qb->getQuery()->getSingleScalarResult();
        $count = (int)$count;
        for ($i = 1; $i <= $count; $i++) {
            $id2 = $i - 1;
            $bankUser = 'bank:User' . $id2;
            $bankMoney = $redis->lrange($bankUser, 0, 0);
            $balance = (int)$bankMoney[0];
            $bank->setMoney($balance);
        }

        // var_dump($count);
        // exit;


        //insert db
        // $bank->setMoney($totalMoney);
        // $bankDetail->setUserName($bankUser);
        // $bankDetail->setNotes('存款');
        // $bankDetail->setCreatedTime($datetime);
        // $bankDetail->setModifyMoney($depositMoney);
        // $bankDetail->setOldMoney($bankMoney);
        // $bankDetail->setNewMoney($totalMoney);

        $entityManager->persist($bank);
        // $entityManager->persist($bankDetail);
        $entityManager->flush();
        $entityManager->clear();
    }
}

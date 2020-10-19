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

        $count = $redis->get('countUser');
        $count = (int)$count;
        //insert Bank
        for ($i = 1; $i <= $count; $i++) {
            $id2 = $i - 1;
            $id = $i;
            $bank = $entityManager->find('BankBundle:Bank', $id);
            $bankUser = 'bank:User' . $id2;
            $bankMoney = $redis->lrange($bankUser, 0, 0);
            $balance = (int)$bankMoney[0];
            $bank->setMoney($balance);
            $entityManager->persist($bank);
            $entityManager->flush();
            $entityManager->clear();
        }

        //insert BankDetail
        $bankDetail = new BankDetail();
        for ($j = 1; $j <= $count; $j++) {
            $id2 = $j - 1;
            $bankUser = 'num:User' . $id2;
            $num = $redis->get($bankUser);
            $num = (int)$num;
            if ($num != 0) {
                for ($k = 1; $k <= $num; $k++) {
                    $detailUser = 'detail:User' . $id2 . ':' . $k;
                    $detail = $redis->HVALS($detailUser);
                    $bankDetail->setNotes($detail[2]);
                    $bankDetail->setUserName($detail[1]);
                    $bankDetail->setModifyMoney($detail[3]);
                    $bankDetail->setOldMoney($detail[4]);
                    $bankDetail->setNewMoney($detail[5]);
                    $bankDetail->setCreatedTime($detail[6]);
                    $entityManager->persist($bankDetail);
                    $entityManager->flush();
                    $entityManager->clear();
                }
            }
        }
        //寫完清除redis
        $redis->FLUSHALL();
        return new Response('Write is finish');
    }
}

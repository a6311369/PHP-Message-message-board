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

            $bankUser = 'modNum' . $id2;
            $num = $redis->get($bankUser);
            $num = (int)$num;

            $modnumbank = $redis->get('modnumBank'.$id);
            if ($modnumbank <= $num){
                $bank = $entityManager->find('BankBundle:Bank', $id);
                $bankUser = 'account' . $id2;
                $bankMoney = $redis->lrange($bankUser, 0, 0);
                $balance = (int)$bankMoney[0];
                $bank->setMoney($balance);
                $entityManager->persist($bank);
                $entityManager->flush();
                $entityManager->clear();
                $redis->incr('modnumBank' . $id2);
            }

        }

        //insert BankDetail
        $bankDetail = new BankDetail();
        for ($j = 1; $j <= $count; $j++) {
            $id2 = $j - 1;

            $bankUser = 'modNum' . $id2;
            $num = $redis->get($bankUser);
            $num = (int)$num;

            $modAccount = 'modAccount' . $id2;
            $num2 = $redis->get($modAccount);
            $num2 = (int)$num2;

            if ($num != 0) {
                $l = 1;
                if ($num >= $num2) {
                    $l = $num2;
                    if ($l == 0) {
                        $l = 1;
                    }
                }
                for ($k = $l; $k <= $num; $k++) {
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
                    $redis->set('modAccount' . $id2, $k);
                }
            }
        }
        return new Response('Write is finish');
    }
}

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
            $bank = $entityManager->find('BankBundle:Bank', $id);
            $bankUser = 'accountUser' . $id2;
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
            $detaiUser = 'detailNum:User' . $id2;
            $detailNum = $redis->llen($detaiUser);
            $detailNum = (int)$detailNum;
            if ($detailNum != 0) {
                for ($k = 1; $k <= $detailNum; $k++) {
                    //redis取值
                    $redis->rpop('detailNum:User' . $id2);
                    $detailNotes = $redis->rpop('detailNotes:User' . $id2);
                    $detailName = $redis->rpop('detailName:User' . $id2);
                    $detailModmoney = $redis->rpop('detailModmoney:User' . $id2);
                    $detailOldmoney = $redis->rpop('detailOldmoney:User' . $id2);
                    $detailNewmoney = $redis->rpop('detailNewmoney:User' . $id2);
                    $detaildate = $redis->rpop('detaildate:User' . $id2);
                    //寫入DB
                    $bankDetail->setNotes($detailNotes);
                    $bankDetail->setUserName($detailName);
                    $bankDetail->setModifyMoney($detailModmoney);
                    $bankDetail->setOldMoney($detailOldmoney);
                    $bankDetail->setNewMoney($detailNewmoney);
                    $bankDetail->setCreatedTime($detaildate);

                    $entityManager->persist($bankDetail);
                    $entityManager->flush();
                    $entityManager->clear();
                }
            }
        }

        return new Response('Write is finish');
    }
}

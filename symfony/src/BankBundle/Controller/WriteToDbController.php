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

        $count = $redis->LLEN('id');
        $count = (int)$count;
        for ($i = 0; $i < $count; $i++) {
            $id = $redis->LINDEX('id', $i);
            $bank = $entityManager->find('BankBundle:Bank', $id);
            $bankId = 'accountId' . $id;
            $bankMoney = $redis->GET($bankId);
            $balance = (int)$bankMoney;
            $bank->setMoney($balance);
            $entityManager->persist($bank);
            $entityManager->flush();
            $entityManager->clear();
        }

        //insert BankDetail
        $bankDetail = new BankDetail();
        for ($j = 0; $j < $count; $j++) {
            $id = $redis->LINDEX('id', $j);
            $detaiUser = 'detailNum:Id:' . $id;
            $detailNum = $redis->GET($detaiUser);
            $detailNum = (int)$detailNum;
            if ($detailNum != 0) {
                for ($k = 1; $k <= $detailNum; $k++) {
                    //redis取值
                    $detailNotes = $redis->rpop('detailNotes:Id:' . $id);
                    $detailModmoney = $redis->rpop('detailModmoney:Id:' . $id);
                    $detailOldmoney = $redis->rpop('detailOldmoney:Id:' . $id);
                    $detailNewmoney = $redis->rpop('detailNewmoney:Id:' . $id);
                    $detaildate = $redis->rpop('detaildate:Id:' . $id);
                    // var_dump($id);exit;

                    //寫入DB
                    $bankDetail->setNotes($detailNotes);
                    $bankDetail->setUserId($id);
                    $bankDetail->setModifyMoney($detailModmoney);
                    $bankDetail->setOldMoney($detailOldmoney);
                    $bankDetail->setNewMoney($detailNewmoney);
                    $bankDetail->setCreatedTime($detaildate);

                    $entityManager->persist($bankDetail);
                    $entityManager->flush();
                    $entityManager->clear();
                }
                $redis->DEL($detaiUser);
                $redis->DEL('detailID:' . $id);
            }
        }

        return new Response('Write is finish');
    }
}

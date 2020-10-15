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


class BankController extends Controller
{

    /**
     * @Route("/bank/deposit", name="deposit", methods={"GET", "POST"}))
     */
    public function depositAction(Request $request)
    {
        //存款
        $id = $request->get('id');
        $depositMoney = $request->get('depositMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');

        $datetime = new \DateTime;
        $bankDetail = new BankDetail();
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $bankUser = $bank->getUser();
        $bankuUser = $bank->getUser();
        $totalMoney = $depositMoney + $bankMoney;


        //insert redis
        $id2 = $id - 1;      
        //取出流水號
        $num = $redis->get('num:User' . $id2);
        if ($num == 0) {
            $redis->set('num:User' . $id2, 1);
            $num2 = $redis->get('num:User' . $id2);
        } else {
            $redis->incr('num:User' . $id2);
            $num2 = $redis->get('num:User' . $id2);
        }
        $detailid = 'detail:User' . $id2 . ':' . $num2;
        
        //紀錄餘額
        $redis->lPush('User' . $id2, $totalMoney);
        //紀錄筆數
        $redis->hmset(
            $detailid,
            'num',
            $num2,
            'name',
            'User' . $id2,
            'note',
            'deposit',
            'modify_money',
            $depositMoney,
            'old_money_money',
            $bankMoney,
            'new_money',
            $totalMoney
        );
        // var_dump($redis->HVALS($detailid));
        // exit;

        $bank->setMoney($totalMoney);
        $bankDetail->setUserName($bankUser);
        $bankDetail->setNotes('存款');
        $bankDetail->setCreatedTime($datetime);
        $bankDetail->setModifyMoney($depositMoney);
        $bankDetail->setOldMoney($bankMoney);
        $bankDetail->setNewMoney($totalMoney);

        $entityManager->persist($bankDetail);
        $entityManager->flush();

        $entityManager->clear();
        $data = [
            'bankuUser' => $bankuUser,
            'depositMoney' => $depositMoney,
            'totalMoney' => $totalMoney,
            'datetime' => $datetime,
        ];

        return new Response(json_encode($data, true));
    }

    /**
     * @Route("/bank/withdraw", name="withdraw", methods={"GET", "POST"}))
     */
    public function withdrawAction(Request $request)
    {
        //提款
        $id = $request->get('id');
        $withdrawMoney = (int)$request->get('withdrawMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');


        $bankDetail = new BankDetail();
        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $bankUser = $bank->getUser();
        $bankuUser = $bank->getUser();
        $totalMoney = $bankMoney - $withdrawMoney;


        //insert redis
        $id2 = $id - 1;
        //取出流水號
        $num = $redis->get('num:User' . $id2);
        if ($num == 0) {
            $redis->set('num:User' . $id2, 1);
            $num2 = $redis->get('num:User' . $id2);
        } else {
            $redis->incr('num:User' . $id2);
            $num2 = $redis->get('num:User' . $id2);
        }
        $detailid = 'detail:User' . $id2 . ':' . $num2;
        
        //紀錄餘額
        $redis->lPush('User' . $id2, $totalMoney);
        //紀錄筆數
        $redis->hmset(
            $detailid,
            'num',
            $num2,
            'name',
            'User' . $id2,
            'note',
            'withdraw',
            'modify_money',
            $withdrawMoney,
            'old_money_money',
            $bankMoney,
            'new_money',
            $totalMoney
        );
        // var_dump($redis->HVALS($detailid));
        // exit;

        $bank->setMoney($totalMoney);
        $bankDetail->setUserName($bankUser);
        $bankDetail->setNotes('提款');
        $bankDetail->setCreatedTime($datetime);
        $bankDetail->setModifyMoney($withdrawMoney);
        $bankDetail->setOldMoney($bankMoney);
        $bankDetail->setNewMoney($totalMoney);

        $entityManager->persist($bankDetail);
        $entityManager->flush();

        $entityManager->clear();
        $data = [
            'bankuUser' => $bankuUser,
            'withdrawMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
            'datetime' => $datetime,
        ];

        return new Response(json_encode($data, true));
    }
}

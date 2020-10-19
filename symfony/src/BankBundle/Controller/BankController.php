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
use BankBundle\Controller\WriteToDbController;

class BankController extends Controller
{

    /**
     * @Route("/bank/deposit", name="deposit", methods={"GET", "POST"}))
     */
    public function depositAction(Request $request)
    {
        //存款
        $id = $request->get('id');
        $id2 = $id - 1;
        $depositMoney = $request->get('depositMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');

        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        //redis沒資料時先預載DB資料,如果redis裡面有資料將不會執行
        if ($redis->keys('*') == null) {
            //計算bank總筆數
            $qb = $entityManager->createQueryBuilder();
            $qb->select('count(account.user)');
            $qb->from('BankBundle:Bank', 'account');
            $count = $qb->getQuery()->getSingleScalarResult();
            $count = (int)$count;
            $redis->set('countUser', $count);
            for ($i = 1; $i <= $count; $i++) {
                //撈出bank資料
                $entityManager = $this->getDoctrine()->getManager();
                $bank = $entityManager->find('BankBundle:Bank', $i);
                $bankUser = $bank->getUser();
                $bankMoney = (int)$bank->getMoney();
                //撈出來資料寫入redis
                $id = $i - 1;

                $redis->lPush('account' . $id, $bankMoney);
                $redis->set('modnumBank' . $id, 0);
            }
        }

        //計算存款後餘額
        $bankUser = 'account' . $id2;
        $bankMoney = $redis->lrange($bankUser, 0, 0);
        $balance = (int)$bankMoney[0];
        $totalMoney = $balance + $depositMoney;

        //insert redis
        //記錄一個帳號異動了幾次
        $num = $redis->get('modNum' . $id2);
        if ($num == 0) {
            $redis->set('modNum' . $id2, 1);
            $num2 = $redis->get('modNum' . $id2);
        } else {
            $redis->incr('modNum' . $id2);
            $num2 = $redis->get('modNum' . $id2);
        }
        $num2 = (int)$num2;
        $detailid = 'detail:User' . $id2 . ':' . $num2;

        //更新餘額
        $redis->lPush('account' . $id2, $totalMoney);
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
            $balance,
            'new_money',
            $totalMoney,
            'datetime',
            $datetime
        );

        $data = [
            'bankuUser' => $bankUser,
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
        $id2 = $id - 1;
        $withdrawMoney = $request->get('withdrawMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');

        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        //redis沒資料時先預載DB資料
        if ($redis->keys('*') == null) {
            //計算bank總筆數
            $qb = $entityManager->createQueryBuilder();
            $qb->select('count(account.user)');
            $qb->from('BankBundle:Bank', 'account');
            $count = $qb->getQuery()->getSingleScalarResult();
            $count = (int)$count;
            $redis->set('countUser', $count);
            for ($i = 1; $i <= $count; $i++) {
                //撈出bank資料
                $entityManager = $this->getDoctrine()->getManager();
                $bank = $entityManager->find('BankBundle:Bank', $i);
                $bankUser = $bank->getUser();
                $bankMoney = (int)$bank->getMoney();
                //撈出來資料寫入redis
                $id = $i - 1;
                $redis->lPush('account' . $id, $bankMoney);
                $redis->set('modnumBank' . $id, 1);
            }
        }

        //計算存款後餘額
        $bankUser = 'account' . $id2;
        $bankMoney = $redis->lrange($bankUser, 0, 0);
        $balance = (int)$bankMoney[0];
        $totalMoney = $balance - $withdrawMoney;

        //insert redis
        //記錄一個帳號異動了幾次
        $num = $redis->get('modNum' . $id2);
        if ($num == 0) {
            $redis->set('modNum' . $id2, 1);
            $num2 = $redis->get('modNum' . $id2);
        } else {
            $redis->incr('modNum' . $id2);
            $num2 = $redis->get('modNum' . $id2);
        }
        $num2 = (int)$num2;
        $detailid = 'detail:User' . $id2 . ':' . $num2;

        //紀錄餘額
        $redis->lPush('account' . $id2, $totalMoney);
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
            $balance,
            'new_money',
            $totalMoney,
            'datetime',
            $datetime
        );

        $data = [
            'bankuUser' => $bankUser,
            'withdrawMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
            'datetime' => $datetime,
        ];

        return new Response(json_encode($data, true));
    }
}

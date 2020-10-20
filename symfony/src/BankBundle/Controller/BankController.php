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
        $depositMoney = $request->get('depositMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');

        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        //redis沒資料時先預載DB資料,如果redis裡面有資料將不會執行
        if ($redis->keys('accountId*') == null) {
            //計算bank有效總筆數
            $qb = $entityManager->createQueryBuilder();
            $qb->select('count(account.user)');
            $qb->from('BankBundle:Bank', 'account');
            $qb->where('account.active = :Y')->setParameter('Y', 'Y');
            $count = $qb->getQuery()->getSingleScalarResult();
            $count = (int)$count;
            $redis->set('countUser', $count);
            //撈出有效帳號的id
            $query = $entityManager->createQuery('SELECT u.id FROM BankBundle:Bank u WHERE u.active = ?1');
            $query->setParameter(1, 'Y');
            $users = $query->getResult();
            foreach ($users as $id) {
                $redis->lPush('id', $id);
            }
            $idIndex = $count - 1;
            for ($i = 1; $i <= $count; $i++) {
                //撈出bank資料
                $id = $redis->LINDEX('id', $idIndex);
                $entityManager = $this->getDoctrine()->getManager();
                $bank = $entityManager->find('BankBundle:Bank', $id);
                $bankUser = $bank->getUser();
                $bankMoney = (int)$bank->getMoney();
                $idIndex = $idIndex - 1;
                //撈出來資料寫入redis
                $redis->lPush('accountId' . $id, $bankMoney);
            }
        }
        //計算存款後餘額
        $bankUser = 'accountId' . $id;
        $bankMoney = $redis->lrange($bankUser, 0, 0);
        $balance = (int)$bankMoney[0];
        $totalMoney = $balance + $depositMoney;
        //更新餘額
        $redis->lPush('accountId' . $id, $totalMoney);

        //insert redis
        //記錄一個帳號異動了幾次
        $num = $redis->get('modid' . $id);
        if ($num == 0) {
            $redis->set('modid' . $id, 1);
            $num2 = $redis->get('modid' . $id);
        } else {
            $redis->incr('modid' . $id);
            $num2 = $redis->get('modid' . $id);
        }
        $num2 = (int)$num2;
        $redis->lPush('detailNum:Id:' . $id, $num2);
        $redis->lPush('detailNotes:id:' . $id, 'deposit');
        $redis->set('detailID:' . $id, $id);
        $redis->lPush('detailModmoney:Id:' . $id, $depositMoney);
        $redis->lPush('detailOldmoney:Id:' . $id, $balance);
        $redis->lPush('detailNewmoney:Id:' . $id, $totalMoney);
        $redis->lPush('detaildate:Id:' . $id, $datetime);

        $data = [
            'bankId' => $id,
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
        $withdrawMoney = $request->get('withdrawMoney');
        $entityManager = $this->getDoctrine()->getManager();
        $redis = $this->container->get('snc_redis.default');

        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        //redis沒資料時先預載DB資料,如果redis裡面有資料將不會執行
        if ($redis->keys('accountId*') == null) {
            //計算bank有效總筆數
            $qb = $entityManager->createQueryBuilder();
            $qb->select('count(account.user)');
            $qb->from('BankBundle:Bank', 'account');
            $qb->where('account.active = :Y')->setParameter('Y', 'Y');
            $count = $qb->getQuery()->getSingleScalarResult();
            $count = (int)$count;
            $redis->set('countUser', $count);
            //撈出有效帳號的id
            $query = $entityManager->createQuery('SELECT u.id FROM BankBundle:Bank u WHERE u.active = ?1');
            $query->setParameter(1, 'Y');
            $users = $query->getResult();
            foreach ($users as $id) {
                $redis->lPush('id', $id);
            }
            $idIndex = $count - 1;
            for ($i = 1; $i <= $count; $i++) {
                //撈出bank資料
                $id = $redis->LINDEX('id', $idIndex);
                $entityManager = $this->getDoctrine()->getManager();
                $bank = $entityManager->find('BankBundle:Bank', $id);
                $bankUser = $bank->getUser();
                $bankMoney = (int)$bank->getMoney();
                $idIndex = $idIndex - 1;
                //撈出來資料寫入redis
                $redis->lPush('accountId' . $id, $bankMoney);
            }
        }
        //計算存款後餘額
        $bankUser = 'accountId' . $id;
        $bankMoney = $redis->lrange($bankUser, 0, 0);
        $balance = (int)$bankMoney[0];
        $totalMoney = $balance - $withdrawMoney;
        //更新餘額
        $redis->lPush('accountId' . $id, $totalMoney);

        //insert redis
        //記錄一個帳號異動了幾次
        $num = $redis->get('modid' . $id);
        if ($num == 0) {
            $redis->set('modid' . $id, 1);
            $num2 = $redis->get('modid' . $id);
        } else {
            $redis->incr('modid' . $id);
            $num2 = $redis->get('modid' . $id);
        }
        $num2 = (int)$num2;
        $redis->lPush('detailNum:Id:' . $id, $num2);
        $redis->lPush('detailNotes:id:' . $id, 'withdrawMoney');
        $redis->set('detailID:' . $id, $id);
        $redis->lPush('detailModmoney:Id:' . $id, $withdrawMoney);
        $redis->lPush('detailOldmoney:Id:' . $id, $balance);
        $redis->lPush('detailNewmoney:Id:' . $id, $totalMoney);
        $redis->lPush('detaildate:Id:' . $id, $datetime);

        $data = [
            'bankId' => $id,
            'depositMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
            'datetime' => $datetime,
        ];

        return new Response(json_encode($data, true));
    }
}

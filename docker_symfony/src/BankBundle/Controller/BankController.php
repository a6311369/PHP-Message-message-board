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
use BankBundle\Service\RedisClient;
use Psr\Log\LoggerInterface;



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
        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');
        $redisService = new RedisClient();
        //判斷是否存在redis
        $this->writeAccountData($id);
        //計算存款後餘額
        $bankUser = 'accountId' . $id;
        $bankMoney = $redisService->getBankMoney($bankUser);
        $balance = (int)$bankMoney;
        $totalMoney = $balance + $depositMoney;
        //更新餘額
        $redisService->setTotalMoney($bankUser, $totalMoney);
        //記錄一個帳號異動了幾次
        $redisService->countModNum($id);
        //交易明細
        $notes = 'deposit';
        $redisService->writeDetail($id, $notes, $depositMoney, $balance, $totalMoney, $datetime);
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
        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');
        $redisService = new RedisClient();
        //判斷是否存在redis
        $this->writeAccountData($id);
        //計算存款後餘額
        $bankUser = 'accountId' . $id;
        $bankMoney = $redisService->getBankMoney($bankUser);
        $balance = (int)$bankMoney;
        $totalMoney = $balance - $withdrawMoney;
        if ($totalMoney < 0) {
            echo '餘額不足，無法提款';
            exit;
        } else {
            //更新餘額
            $redisService->setTotalMoney($bankUser, $totalMoney);
        }
        //記錄一個帳號異動了幾次
        $redisService->countModNum($id);
        //明細
        $notes = 'withdrawMoney';
        $redisService->writeDetail($id, $notes, $withdrawMoney, $balance, $totalMoney, $datetime);
        $data = [
            'bankId' => $id,
            'withdrawMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
            'datetime' => $datetime,
        ];

        return new Response(json_encode($data, true));
    }
    //判斷AccountId
    private function writeAccountData($id)
    {
        $redisService = new RedisClient();
        $accountId = $redisService->getAccountId($id);
        if ($accountId == true) {
            $entityManager = $this->getDoctrine()->getManager();
            $bank = $entityManager->find('BankBundle:Bank', $id);
            $bankMoney = (int)$bank->getMoney();
            $redisService->setBankMoney($id, $bankMoney);
        }
    }
}

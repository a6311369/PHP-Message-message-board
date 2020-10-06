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
        $entityManager->getConnection()->beginTransaction();
        try {
            $datetime = new \DateTime;
            $bankDetail = new BankDetail();
            $datetime = $datetime->format('Y-m-d H:i:s.u');

            $bank = $entityManager->find('BankBundle:Bank', $id, LockMode::PESSIMISTIC_WRITE);
            $bankMoney = (int)$bank->getMoney();
            $bankUser = $bank->getUser();
            $bankuUser = $bank->getUser();
            $totalMoney = $depositMoney + $bankMoney;

            $bank->setMoney($totalMoney);
            $bankDetail->setUserName($bankUser);
            $bankDetail->setNotes('存款');
            $bankDetail->setCreatedTime($datetime);

            $entityManager->persist($bankDetail);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollBack();
            throw $e;
        }
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
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->getConnection()->beginTransaction();
        try {
            $bankDetail = new BankDetail();
            $datetime = new \DateTime;
            $datetime = $datetime->format('Y-m-d H:i:s.u');

            $bank = $entityManager->find('BankBundle:Bank', $id, LockMode::PESSIMISTIC_WRITE);
            $bankMoney = (int)$bank->getMoney();
            $bankUser = $bank->getUser();
            $bankuUser = $bank->getUser();
            $totalMoney = $bankMoney - $withdrawMoney;

            $bank->setMoney($totalMoney);
            $bankDetail->setUserName($bankUser);
            $bankDetail->setNotes('提款');
            $bankDetail->setCreatedTime($datetime);

            $entityManager->persist($bankDetail);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollBack();
            throw $e;
        }
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

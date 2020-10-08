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

        $datetime = new \DateTime;
        $bankDetail = new BankDetail();
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $bankUser = $bank->getUser();
        $bankuUser = $bank->getUser();
        $version = $bank->getVersion();
        $totalMoney = $depositMoney + $bankMoney;
        //樂觀鎖
        try {
            $entityManager->lock($bank, LockMode::OPTIMISTIC, $version);

            $bank->setMoney($totalMoney);
            $bankDetail->setUserName($bankUser);
            $bankDetail->setNotes('存款');
            $bankDetail->setCreatedTime($datetime);
            $bankDetail->setModifyMoney($depositMoney);
            $bankDetail->setOldMoney($bankMoney);
            $bankDetail->setNewMoney($totalMoney);

            $entityManager->persist($bankDetail);
            $entityManager->flush();
        } catch (OptimisticLockException  $e) {
            echo "Sorry, but someone else has already changed this entity. Please apply the changes again!";
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

        $bankDetail = new BankDetail();
        $datetime = new \DateTime;
        $datetime = $datetime->format('Y-m-d H:i:s.u');

        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $bankUser = $bank->getUser();
        $bankuUser = $bank->getUser();
        $version = $bank->getVersion();
        $totalMoney = $bankMoney - $withdrawMoney;
        //樂觀鎖
        try {

            $entityManager->lock($bank, LockMode::OPTIMISTIC, $version);

            $bank->setMoney($totalMoney);
            $bankDetail->setUserName($bankUser);
            $bankDetail->setNotes('提款');
            $bankDetail->setCreatedTime($datetime);
            $bankDetail->setModifyMoney($withdrawMoney);
            $bankDetail->setOldMoney($bankMoney);
            $bankDetail->setNewMoney($totalMoney);

            $entityManager->persist($bankDetail);
            $entityManager->flush();
        } catch (OptimisticLockException  $e) {
            echo "Sorry, but someone else has already changed this entity. Please apply the changes again!";
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

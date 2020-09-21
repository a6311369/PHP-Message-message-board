<?php

namespace BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BankBundle\Entity\Bank;
use BankBundle\Entity\Bankdetail;


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
        // $bankdetail = new Bankdetail();
        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankmoney = (int)$bank->getMoney();
        $totalMoney = $depositMoney + $bankmoney;
        $bankuUser = $bank->getUser();
        $bank->setMoney($totalMoney);
        // $bankdetail->setUser_id($id);
        // $bankdetail->setNotes('存款');
        // $entityManager->persist($bankdetail);
        // $entityManager->flush();
        // $entityManager->clear();

        $data = [
            'bankuUser' => $bankuUser,
            'depositMoney' => $depositMoney,
            'totalMoney' => $totalMoney,
        ];

        return new Response(json_encode($data));
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
        $bankdetail = new Bankdetail();
        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankmoney = (int)$bank->getMoney();
        $totalMoney = $bankmoney - $withdrawMoney;
        $bankuUser = $bank->getUser();
        $bank->setMoney($totalMoney);
        $bankdetail->setUser_id($id);
        $bankdetail->setNotes('提款');
        $entityManager->persist($bankdetail);
        $entityManager->flush();
        $entityManager->clear();
        $data = [
            'bankuUser' => $bankuUser,
            'withdrawMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
        ];

        return new Response(json_encode($data));
    }
}

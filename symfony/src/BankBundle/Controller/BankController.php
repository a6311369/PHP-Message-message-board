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
        $bankDetail = new BankDetail();
        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $bankUser = $bank->getUser();       
        $totalMoney = $depositMoney + $bankMoney;


        $bankuUser = $bank->getUser();
        $bank->setMoney($totalMoney);
        $bankDetail->setUserName($bankUser);
        $bankDetail->setNotes('存款');


        $entityManager->persist($bankDetail);
        $entityManager->flush();
        $entityManager->clear();


        $data = [
            'bankuUser' => $bankuUser,
            'depositMoney' => $depositMoney,
            'totalMoney' => $totalMoney,
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
        $bank = $entityManager->find('BankBundle:Bank', $id);
        $bankMoney = (int)$bank->getMoney();
        $totalMoney = $bankMoney - $withdrawMoney;
        $bankUser = $bank->getUser();       
        $bankuUser = $bank->getUser();
        $bank->setMoney($totalMoney);
        $bankDetail->setUserName($bankUser);
        $bankDetail->setNotes('提款');


        $entityManager->persist($bankDetail);
        $entityManager->flush();
        $entityManager->clear();


        $data = [
            'bankuUser' => $bankuUser,
            'withdrawMoney' => $withdrawMoney,
            'totalMoney' => $totalMoney,
        ];


        return new Response(json_encode($data, true));
    }
}

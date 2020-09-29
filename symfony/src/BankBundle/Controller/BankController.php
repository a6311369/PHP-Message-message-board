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
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function depositAction($id)
    {
        $bankRepository = $this->objectManager
            ->getRepository(Bank::class);
        $bank = $bankRepository->find($id);

        return array($bank->getUser(), $bank->getMoney());

        //存款(Test code)
        // $entityManager = $this->getDoctrine()->getManager();
        // $bank = $entityManager->find('BankBundle:Bank', $id);
        // $bankMoney = (int)$bank->getMoney();
        // $bankUser = $bank->getUser();
        // $totalMoney = $depositMoney + $bankMoney;

        // $bank->setMoney($totalMoney);
        // $bankDetail->setUserName($bankUser);
        // $bankDetail->setNotes('存款');

        // $entityManager->persist($bankDetail);
        // $entityManager->flush();
        // $entityManager->clear();

        // $data = [
        //     'bankuUser' => $bankUser,
        //     'depositMoney' => $depositMoney,
        //     'totalMoney' => $totalMoney,
        // ];

        // return $bankUser;
        

        // //存款(原有code-BK)
        // $id = $request->get('id');
        // $depositMoney = $request->get('depositMoney');
        // $entityManager = $this->getDoctrine()->getManager();
        // $bankDetail = new BankDetail();
        // $bank = $entityManager->find('BankBundle:Bank', $id);
        // $bankMoney = (int)$bank->getMoney();
        // $bankUser = $bank->getUser();
        // $totalMoney = $depositMoney + $bankMoney;

        // $bank->setMoney($totalMoney);
        // $bankDetail->setUserName($bankUser);
        // $bankDetail->setNotes('存款');

        // $entityManager->persist($bankDetail);
        // $entityManager->flush();
        // $entityManager->clear();

        // $data = [
        //     'bankuUser' => $bankUser,
        //     'depositMoney' => $depositMoney,
        //     'totalMoney' => $totalMoney,
        // ];

        // return new Response(json_encode($data, true));
    }

    public function withdrawAction($id)
    {
        $bankRepository = $this->objectManager
            ->getRepository(Bank::class);
        $bank = $bankRepository->find($id);

        return array($bank->getUser(), $bank->getMoney());



        //     //提款(原有code-BK)
        //     $id = $request->get('id');
        //     $withdrawMoney = (int)$request->get('withdrawMoney');
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $bankDetail = new BankDetail();
        //     $bank = $entityManager->find('BankBundle:Bank', $id);
        //     $bankMoney = (int)$bank->getMoney();
        //     $totalMoney = $bankMoney - $withdrawMoney;
        //     $bankUser = $bank->getUser();
        //     $bank->setMoney($totalMoney);
        //     $bankDetail->setUserName($bankUser);
        //     $bankDetail->setNotes('提款');

        //     $entityManager->persist($bankDetail);
        //     $entityManager->flush();
        //     $entityManager->clear();

        //     $data = [
        //         'bankuUser' => $bankUser,
        //         'withdrawMoney' => $withdrawMoney,
        //         'totalMoney' => $totalMoney,
        //     ];

        //     return new Response(json_encode($data, true));
    }


}

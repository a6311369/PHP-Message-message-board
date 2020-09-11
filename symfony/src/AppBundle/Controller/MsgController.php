<?php
// src/AppBundle/Controller/MsgController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Msg;
use AppBundle\Entity\Reply;


class MsgController extends Controller
{
    /**
     * @Route("/msg/home")
     */
    public function homeAction()
    {
        return $this->render('msg/msg.html.twig');
    }

    /**
     * @Route("/msg/creat")
     */
    public function creatAction()
    {

        $newName = trim($_POST['name']);
        $newDescr = trim($_POST['content']);
        $entityManager = $this->getDoctrine()->getManager();
        $msg = new Msg();

        $msg->setName($newName);
        $msg->setDescr($newDescr);

        $entityManager->persist($msg);
        $entityManager->flush();

        $msgid = $msg->getId();
        return $this->render('msg/creat.html.twig', [
            'msgid' => $msgid,
        ]);
    }


    /**
     * @Route("/msg/test")
     */
    public function testAction()
    {
        $newName = trim($_POST['name']);
        $newDescr = trim($_POST['content']);

        return $this->render('msg/test.html.twig', [
            'newName' => $newName, 'newDescr' => $newDescr,
        ]);
    }
    /**
     * @Route("/msg/test2")
     */
    public function test2Action()
    {

        return $this->render('msg/test2.html.twig');
    }

    /**
     * @Route("/msg/batchremove")
     */
    public function batchRemoveAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $msg = new Msg();

        $batchSize = 2000;
        $i = 1;
        $q = $entityManager->createQuery('select m from AppBundle:msg m');
        $iterableResult = $q->iterate();
        while (($row = $iterableResult->next()) !== false) {
            $entityManager->remove($row[0]);
            if (($i % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }
            ++$i;
        }
        $entityManager->flush();
        
        return $this->render('msg/batchremove.html.twig');
    }


    /**
     * @Route("/msg/batchcreate")
     */
    public function batchCreateAction()
    {
        return $this->redirect('test2');

        // $entityManager = $this->getDoctrine()->getManager();
        // $msg = new Msg();
        // $entityManager->persist($msg);
        // $entityManager->flush();

    }
}

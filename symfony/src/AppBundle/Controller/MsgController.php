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
     * @Route("/msg/home", name="home")
     */
    public function homeAction()
    {
        return $this->render('msg/msg.html.twig');
    }

    /**
     * @Route("/msg/creat", name="creat")
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
            'msgid' => $msgid, 'msgname' => $newName,
        ]);
    }

    /**
     * @Route("/msg/creatreply", name="creatreply")
     */
    public function creatReplyAction()
    {

        $newMsg = trim($_POST['reply_id']);
        $newMsg2 = (int)trim($_POST['reply_id']);
        $newMessage = trim($_POST['reply_message']);
        $entityManager = $this->getDoctrine()->getManager();
        $msg = new Msg();
        $newReply = new Reply();

        $msg = $entityManager->find('AppBundle:Msg', $newMsg);
        $newReply->setMsg($msg);
        $newReply->setMessage($newMessage);
        $newReply->setnum($newMsg2);
        $entityManager->persist($newReply);
        $entityManager->flush();
        $entityManager->clear();

        return $this->render('msg/creatreply.html.twig');
    }

    /**
     * @Route("/msg/remove", name="remove")
     */
    public function removeAction()
    {
        $id = trim($_POST['del_id']);
        $entityManager = $this->getDoctrine()->getManager();
        $msgs = $entityManager->find('AppBundle:Msg', $id);
        $replyRepository = $entityManager->getRepository('AppBundle:Reply');
        $reply = $replyRepository->findBy(array('num' => $id));
        foreach ($reply as $reply) {
            $entityManager->remove($reply);
        }       
        $entityManager->remove($msgs);
        $entityManager->flush();
        $entityManager->clear();
        return $this->render('msg/remove.html.twig');
    }

    /**
     * @Route("/msg/delreply", name="delreply")
     */
    public function delreplyAction()
    {
        $id = trim($_POST['del_re_id']);
        $entityManager = $this->getDoctrine()->getManager();

        $delReply = $entityManager->find('AppBundle:Reply', $id);
        $entityManager->remove($delReply);
        $entityManager->flush();
        $entityManager->clear();

        return $this->render('msg/remove.html.twig');
    }

    /**
     * @Route("/msg/update", name="update")
     */
    public function updateAction()
    {

        $id = trim($_POST['mod_id']);
        $newDescr = trim($_POST['mod_content']);
        $entityManager = $this->getDoctrine()->getManager();
        $msg = new Msg();

        $msg = $entityManager->find('AppBundle:Msg', $id);
        $msg->setDescr($newDescr);
        $entityManager->flush();
        $entityManager->clear();

        return $this->render('msg/update.html.twig', [
            'id' => $id,
        ]);
    }

    /**
     * @Route("/msg/list", name="list")
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $countMsg = $entityManager->getRepository(Msg::class);
        $msgCount = $countMsg->createQueryBuilder('m')
            ->select('count(m.name)')
            ->getQuery()
            ->getSingleScalarResult();

        $msgRepository = $entityManager->getRepository('AppBundle:Msg');
        $messages = $msgRepository->findBy(array(), array());

        $replyRepository = $entityManager->getRepository('AppBundle:Reply');
        $replies = $replyRepository->findBy(array(), array());

        return $this->render('msg/list.html.twig', [
            'msgCount' => $msgCount, 'messages' => $messages, 'replies' => $replies
        ]);
    }

    /**
     * @Route("/msg/batchremove", name="batchremove")
     */
    public function batchRemoveAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager
            ->createQueryBuilder()
            ->delete('AppBundle:Msg', 'm');
        $queryBuilder->getQuery()->execute();
        $entityManager->flush();
        $entityManager->clear();

        return $this->render('msg/batchremove.html.twig');
    }

    /**
     * @Route("/msg/batchcreate", name="batchcreate")
     */
    public function batchCreateAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $batchSize = 2000;
        for ($i = 1; $i <= 5; ++$i) {
            $msg = new Msg;
            $msg->setName('user' . $i);
            $msg->setDescr('Mr.Smith-' . $i);
            $entityManager->persist($msg);
            if (($i % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }
        }
        $entityManager->flush();
        $entityManager->clear();


        return $this->render('msg/batchcreate.html.twig');
    }
}

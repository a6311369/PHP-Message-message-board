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

        $msg = $entityManager->find('AppBundle:Msg', $newMsg);

        $newReply = new Reply();
        $newReply->setMsg($msg);
        $newReply->setMessage($newMessage);
        $newReply->setId2($newMsg2);

        $entityManager->persist($newReply);
        $entityManager->flush();

        return $this->render('msg/creatreply.html.twig');

    }

    /**
     * @Route("/msg/remove", name="remove")
     */
    public function removeAction()
    {
        $id = trim($_POST['del_id']);
        $entityManager = $this->getDoctrine()->getManager();

        $msg = $entityManager->find('AppBundle:Msg', $id);
        $entityManager->remove($msg);
        $entityManager->flush();
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

        return $this->render('msg/update.html.twig', [
            'id' => $id,
        ]);
    }

    /**
     * @Route("/msg/list", name="list")
     */
    public function listAction()
    {
        //count msg 
        $entityManager = $this->getDoctrine()->getManager();
        $countMsg = $entityManager->getRepository(Msg::class);
        $msgCount = $countMsg->createQueryBuilder('m')
            ->select('count(m.name)')
            ->getQuery()
            ->getSingleScalarResult();

        //分頁-s-
        // // 每頁筆數
        // $per = 5;
        // // 計算頁數
        // $pages = ceil($msgCount / $per);
        // // 獲取當前頁碼
        // if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
        //     $page = 1; //則在此設定起始頁數
        // } else {
        //     $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        // }
        // $start = ($page - 1) * $per; //每一頁開始的資料序號
        $msgRepository = $entityManager->getRepository('AppBundle:Msg');
        // // $msgs = $msgRepository->findBy(array(), array(), $per, $start);
        $messages = $msgRepository->findBy(array(), array());

        $replyRepository = $entityManager->getRepository('AppBundle:Reply');
        $replies = $replyRepository->findBy(array(), array());
        


        //分頁-e-


        return $this->render('msg/list.html.twig', [
            'msgCount' => $msgCount, 'messages' => $messages, 'replies' => $replies
        ]);
        // return $this->render('msg/list.html.twig', [
        //     'msgCount' => $msgCount, 'messages' => $messages
        // ]);
    }



    /**
     * @Route("/msg/batchremove", name="batchremove")
     */
    public function batchRemoveAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $msg = new Msg();

        $batchSize = 2000;
        $i = 1;
        $q = $entityManager->createQuery('select m from AppBundle:Msg m');
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
     * @Route("/msg/batchcreate", name="batchcreate")
     */
    public function batchCreateAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stime = microtime(true);

        $batchSize = 2000;
        for ($i = 1; $i <= 10; ++$i) {
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

        $etime = microtime(true);
        $total = $etime - $stime;
        return $this->render('msg/batchcreate.html.twig', [
            'total' => $total,
        ]);
    }
}

<?php
// src/AppBundle/Controller/MsgController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MsgController extends Controller
{
    /**
     * @Route("/msg/home")
     */
    public function HomeAction()
    {
        return $this->render('msg/msg.html.twig');
    }

    /**
     * @Route("/msg/test")
     */
    public function TestAction()
    {
        // $newName = 1;
        
        $newName = trim($_POST['name']);
        $newDescr = trim($_POST['content']);

        return $this->render('msg/test.html.twig', [
            'newName' => $newName, 'newDescr' => $newDescr,
        ]);
    }
}

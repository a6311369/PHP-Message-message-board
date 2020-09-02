<?php
require_once "bootstrap.php";

$newName = trim($_POST['bname']);
$newDescr = trim($_POST['bcontent']);

batch_creat($newName, $newDescr);

function batch_creat($name, $descr)
{
    for ($i = 1; $i <= 5; ++$i) {
        $bname = '機器人' . $name . $i;
        $bdescr = '機器人第' . $i . '次留言 : ' . $descr;
        //     $msg = new Msg();
        //     $msg->setName($newName);
        //     $msg->setDescr($newDescr);
        //     $entityManager->persist($msg);
        // }
        // $entityManager->flush();
        // echo "<h3> 批次留言成功 </h3>";
        echo "<h3> " . $bname . "</h3>";
        echo "<h3> " . $bdescr . "</h3>";
    }
}

// require_once "index.html";

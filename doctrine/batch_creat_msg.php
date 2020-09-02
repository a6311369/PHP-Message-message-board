<?php
require_once "bootstrap.php";

$newName = trim($_POST['bname']);
$newDescr = trim($_POST['bcontent']);

for ($i = 1; $i <= 5; ++$i) {
    $bname = $newName;
    $bdescr = '第' . $i . '次留言 : ' . $newDescr;
    $msg = new Msg();
    $msg->setName($bname);
    $msg->setDescr($bdescr);
    $entityManager->persist($msg);
}
$entityManager->flush();
echo "<h3> 批次留言成功 </h3>";


require_once "index.html";

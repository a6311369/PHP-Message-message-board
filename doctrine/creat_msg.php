<?php
require_once "bootstrap.php";

$newName = trim($_POST['name']);
$newDescr = trim($_POST['content']);

$msg = new Msg();
$msg->setName($newName);
$msg->setDescr($newDescr);

$entityManager->persist($msg);
$entityManager->flush();
echo "<h3> 留言成功 </h3>";
require_once "index.html";

<?php
require_once "bootstrap.php";

$newMsg = trim($_POST['reply_id']);
$newMessage = trim($_POST['reply_message']);
$msg = $entityManager->find('Msg', $newMsg);

$newReply = new Reply();
$newReply->setMsg($msg);
$newReply->setMessage($newMessage);

$entityManager->persist($newReply);
$entityManager->flush();

require_once "list_msg.php";

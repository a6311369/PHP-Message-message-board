<?php
require_once "bootstrap.php";

$newMsgid = trim($_POST['reply_id']);
$newMessage = trim($_POST['reply_message']);

$reply = new Reply();
$reply->setMsgid($newMsgid);
$reply->setMessage($newMessage);

$entityManager->persist($reply);
$entityManager->flush();

require_once "list_msg.php";

<?php
// create_reply.php <name>
require_once "bootstrap.php";

$newMsgId = trim($_POST['reply_id']);
$newMessage = trim($_POST['reply_message']);

$reply = new Reply();
$reply->setMsgId($newMsgId);
$reply->setMessage($newMessage);

$entityManager->persist($reply);
$entityManager->flush();
require_once "list_msg.php";

// echo "Created Product with ID " . $reply->getId() . "\n";

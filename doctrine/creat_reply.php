<?php
// create_msg.php <name>
require_once "bootstrap.php";

$newMsgId = $argv[1];
$newMessage = $argv[2];

$reply = new Reply();
$reply->setMsgId($newMsgId);
$reply->setMessage($newMessage);

$entityManager->persist($reply);
$entityManager->flush();

echo "Created Product with ID " . $reply->getId() . "\n";
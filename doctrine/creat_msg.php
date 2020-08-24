<?php
// create_msg.php <name>
require_once "bootstrap.php";

$newName = $argv[1];
$newDescr = $argv[2];

$msg = new Msg();
$msg->setName($newName);
$msg->setDescr($newDescr);

$entityManager->persist($msg);
$entityManager->flush();

echo "Created Product with ID " . $msg->getId() . "\n";
<?php
// list_msg.php
require_once "bootstrap.php";

$msgRepository = $entityManager->getRepository('Msg');
$msg = $msgRepository->findAll();

foreach ($msg as $msg) {
    echo sprintf("-%s\n", $msg->getID());
    echo sprintf("-%s\n", $msg->getName());
    echo sprintf("-%s\n", $msg->getDescr());
}


require_once "index.html";

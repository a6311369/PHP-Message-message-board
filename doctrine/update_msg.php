<?php
// update_msg.php <id> <new-descr>
require_once "bootstrap.php";

$id = $argv[1];
$newDescr = $argv[2];

$msg = $entityManager->find('Msg', $id);

if ($msg === null) {
    echo "Product $id does not exist.\n";
    exit(1);
}

$msg->setDescr($newDescr);

$entityManager->flush();

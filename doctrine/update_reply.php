<?php
// update_msg.php <id> <new-descr>
require_once "bootstrap.php";

$id = $argv[1];
$msdId = $argv[2];

$reply = $entityManager->find('Reply', $id);

if ($reply === null) {
    echo "replyId :  $id does not exist.\n";
    exit(1);
}

$reply->setMsgId($msdId);

$entityManager->flush();

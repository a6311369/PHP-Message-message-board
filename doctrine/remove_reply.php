<?php
require_once "bootstrap.php";

$message = trim($_POST['del_re_message']);
$msgId = trim($_POST['del_re_id']);

$replyRepository = $entityManager->getRepository('Reply');
$reply = $replyRepository->findBy(array('msgid' => $msgId, 'message' => $message));

foreach ($reply as $reply) {
    $entityManager->remove($reply);
}
$entityManager->flush();

require_once "list_msg.php";

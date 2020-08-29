<?php
require_once "bootstrap.php";

$msgId = trim($_POST['del_re_id']);
$message = trim($_POST['del_re_message']);

$msgRepository = $entityManager->getRepository('Msg');
$msg = $msgRepository->findAll();

$replyId = $msgId;
$replyRepository = $entityManager->getRepository('Reply');
$reply = $replyRepository->findBy(array('id' => $replyId, 'message' => $message));

foreach ($reply as $reply) {
    // echo 'test' . $reply->getMessage() . '<br>';

    $entityManager->remove($reply);
}
// }
$entityManager->flush();
require_once "list_msg.php";

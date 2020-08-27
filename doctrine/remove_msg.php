<?php
require_once "bootstrap.php";

$id = trim($_POST['del_id']);
// $msgId = trim($_POST['del_id']);

$msg = $entityManager->find('Msg', $id);
$entityManager->remove($msg);
$entityManager->flush();
// $replyRepository = $entityManager->getRepository('Reply');
// $reply = $replyRepository->findBy(array('msgId' => $msgId));

// foreach ($reply as $reply) {
//     $entityManager->remove($reply);
// }
// $entityManager->flush();

require_once "list_msg.php";

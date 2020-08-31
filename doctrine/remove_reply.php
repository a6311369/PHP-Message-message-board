<?php
require_once "bootstrap.php";

$id = trim($_POST['del_re_id']);
$msg = $entityManager->find('Reply', $id);
$entityManager->remove($msg);
$entityManager->flush();


// $msgId = trim($_POST['del_re_id']);
// $message = trim($_POST['del_re_message']);

// $msgRepository = $entityManager->getRepository('Msg');
// $msg = $msgRepository->findAll();

// $replyRepository = $entityManager->getRepository('Reply');
// $reply = $replyRepository->findBy(array('id' => $msgId, 'message' => $message));

// foreach ($reply as $reply) {
//     $entityManager->remove($reply);
// }
// $entityManager->flush();

require_once "list_msg.php";

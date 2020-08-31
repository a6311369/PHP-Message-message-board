<?php
require_once "bootstrap.php";

$msgId = trim($_POST['del_re_id']);
$message = trim($_POST['del_re_message']);

//先找出關聯的主表，Msg Entity，不先找出來這個附表會不知道關聯的，因為有設定Entity associations
$msgRepository = $entityManager->getRepository('Msg');
$msg = $msgRepository->findAll();

//再去找關聯的附表要去刪除的表，Reply Entity 
$replyRepository = $entityManager->getRepository('Reply');
$reply = $replyRepository->findBy(array('id' => $msgId, 'message' => $message));

foreach ($reply as $reply) {
    $entityManager->remove($reply);
}
$entityManager->flush();

require_once "list_msg.php";

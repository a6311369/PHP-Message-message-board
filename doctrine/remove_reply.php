<?php
require_once "bootstrap.php";

$msgId = trim($_POST['del_re_id']);
$msg = $entityManager->find('Reply', $msgId);
$entityManager->remove($msg);
$entityManager->flush();


require_once "list_msg.php";

<?php
require_once "bootstrap.php";

$id = trim($_POST['del_re_id']);

$msg = $entityManager->find('Reply', $id);
$entityManager->remove($msg);
$entityManager->flush();

require_once "list_msg.php";

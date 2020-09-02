<?php
require_once "bootstrap.php";

$del_Name = trim($_POST['batch_del_name']);

$msgRepository = $entityManager->getRepository('Msg');
$msg = $msgRepository->findBy(array('name' => $del_Name));
foreach ($msg as $msg) {
    $entityManager->remove($msg);
}
$entityManager->flush();

require_once "list_msg.php";

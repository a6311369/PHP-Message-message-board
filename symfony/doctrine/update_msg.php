<?php
require_once "bootstrap.php";

$id = trim($_POST['mod_id']);
$newDescr = trim($_POST['mod_content']);

$msg = $entityManager->find('Msg', $id);
$msg->setDescr($newDescr);
$entityManager->flush();

require_once "list_msg.php";

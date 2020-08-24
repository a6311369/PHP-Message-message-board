<?php
// remove_msg.php
require_once "bootstrap.php";

$id = $argv[1];
$msg = $entityManager->find('Msg', $id);
// var_dump(7, $msg);
$entityManager->remove($msg);
$entityManager->flush();

<?php
// update_msg.php <id> <new-descr>
require_once "bootstrap.php";

$id = trim($_POST['mod_id']);
$newDescr = trim($_POST['mod_content']);

$msg = $entityManager->find('Msg', $id);

// if ($msg === null) {
//     echo "Product $id does not exist.\n";
//     exit(1);
// }

$msg->setDescr($newDescr);
$entityManager->flush();

require_once "list_msg.php";

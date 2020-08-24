<?php
// show_msg.php <id>
require_once "bootstrap.php";

$id = $argv[1];
$msg = $entityManager->find('Msg', $id);

if ($msg === null) {
    echo "No msg found.\n";
    exit(1);
}

echo sprintf("-%s\n", $msg->getName());

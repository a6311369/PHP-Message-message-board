<?php
require_once "pdo.php";

$del_id = trim($_POST['del_id']);
$query = "DELETE FROM msg WHERE `id` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_id);
$tis->execute();

$del_id2 = $del_id;
$query2 = "DELETE FROM reply WHERE `msg_id` = ?";
$tis2 = $conn->prepare($query2);
$tis2->bindParam(1, $del_id);
$tis2->execute();

require_once "list.php";


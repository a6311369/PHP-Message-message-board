<?php
require_once "pdo.php";

$del_id = $_POST['del_id'];
$query = "DELETE FROM msg WHERE `id` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_id);
$tis->execute();

$del_id2 = $_POST['del_id'];
$query2 = "DELETE FROM reply WHERE `id` = ?";
$tis2 = $conn->prepare($query2);
$tis2->bindParam(1, $del_id);
$tis2->execute();

require_once "list.php";

<?php
require_once "pdo.php";

$del_re_message = $_POST['del_re_message'];
$query = "DELETE FROM  reply WHERE `message` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_re_message);
$tis->execute();

require_once "list.php";

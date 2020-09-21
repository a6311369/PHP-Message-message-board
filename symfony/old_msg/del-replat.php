<?php
require_once "pdo.php";

$del_re_message = trim($_POST['del_re_message']);
$del_re_id = trim($_POST['del_re_id']);
$query = "DELETE FROM  reply WHERE `message` = ? AND `id` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_re_message);
$tis->bindParam(2, $del_re_id);
$tis->execute();

require_once "list.php";

<?php
require_once "pdo.php";

$mod_id = trim($_POST['mod_id']);
$mod_content = trim($_POST['mod_content']);

$query = "UPDATE msg SET `descr` = ? WHERE `id` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $mod_content);
$tis->bindParam(2, $mod_id);
$tis->execute();
require_once "list.php";

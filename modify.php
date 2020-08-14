<?php
require_once "pdo.php";

$mod_name = $_POST['mod_name'];
$mod_content = $_POST['mod_content'];

$query  = "UPDATE msg SET `descr` = ? WHERE `name` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1,$mod_content);
$tis->bindParam(2,$mod_name);
$tis->execute();
require_once "list.php";

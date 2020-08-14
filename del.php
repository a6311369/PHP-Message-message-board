<?php
require_once "pdo.php";

$del_id = $_POST['del_id'];
$query = "DELETE FROM msg WHERE `id` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_id);
$tis->execute();

require_once "list.php";

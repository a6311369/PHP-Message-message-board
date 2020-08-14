<?php
require_once  "pdo.php";

$del_name = $_POST['del_name'];
$query = "DELETE FROM msg WHERE `name` = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1,$del_name);
$tis->execute();

require_once "list.php";

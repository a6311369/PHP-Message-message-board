<?php
require_once "pdo.php";

$del_id = $_POST['del_id'];
$query = "DELETE a.*, b.* FROM msg as a, reply as b WHERE a.id = b.msg_id AND a.id = ?";
$tis = $conn->prepare($query);
$tis->bindParam(1, $del_id);
$tis->execute();


require_once "list.php";

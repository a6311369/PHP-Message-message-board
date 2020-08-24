<?php
require_once "pdo.php";

$reply_id = trim($_POST['reply_id']);
$reply_message = trim($_POST['reply_message']);

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO reply(msg_id, message) values(?, ?)";
    $tis = $conn->prepare($query);
    $tis->bindParam(1, $reply_id);
    $tis->bindParam(2, $reply_message);
    $tis->execute();
    echo "<h3> 回覆成功 </h3>";
} catch (PDOException $e) {
    echo "<h3> 回覆失敗 </h3>";
}

require_once "list.php";
?>

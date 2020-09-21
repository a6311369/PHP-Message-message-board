<!DOCTYPE html>
<html>
    <head>
        <title>留言寫入Mysql</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body></body>
</html>

<?php
require_once "pdo.php";

$name =  trim($_POST['name']);
$content = trim($_POST['content']);

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO msg(name, descr) values(?, ?)";
    $tis = $conn->prepare($query);
    $tis->bindParam(1, $name);
    $tis->bindParam(2, $content);
    $tis->execute();
    echo "<h3> 留言成功 </h3>";
} catch (PDOException $e) {
    echo "<h3> 留言失敗 </h3>";
}

$conn = null;
require_once "index.html";
?>

</body>
</html>

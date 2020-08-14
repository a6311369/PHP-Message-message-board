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

$name = $_POST['name'];
$content = $_POST['content'];
$content = '';

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO msg(name, descr, id) values(?, ?, ?)";
    $tis = $conn->prepare($query);
    $tis->bindParam(1, $name);
    $tis->bindParam(2, $content);
    $tis->bindParam(3, $id);
    $tis->execute();
    echo "<h3> 留言成功 </h3>";
} catch (PDOException $e) {
    //echo $sql . "<br>" . $e->getMessage();
    echo "<h3> 留言失敗 </h3>";
}

$conn = null;
require_once "index.html";
?>

</body>
</html>

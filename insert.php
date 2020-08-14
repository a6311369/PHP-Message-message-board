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
error_reporting(E_ALL);
ini_set('display_errors', 1);

//接收變數
$name = $_POST['name'];
$content = $_POST['content'];

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO msg(name, descr) values(?, ?)";
    $tis = $conn->prepare($query);
    $tis->bindParam(1, $name);
    $tis->bindParam(2, $content);
    $tis->execute();
    echo "<h3> 留言成功 </h3>";
} catch (PDOException $e) {
    //echo $sql . "<br>" . $e->getMessage();
    echo "<h3> 留言失敗,暱稱重複 </h3>";
}




//關閉連線
$conn = null;
require_once "index.html";
?>

</body>
</html>

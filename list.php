<!doctype html>
<html>
<head><title>顯示資料</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
require_once  "pdo.php";

$tis = $conn->query('SELECT * FROM msg');

echo "留言內容";
echo "<p>";
echo "<table width=400 border=1>";

while ($row = $tis->fetch())
{
    echo "<tr><td> 留言者 : ".$row['name']." 留言 : ".$row['descr']."</td></tr>";
}

echo "</table>";

?>
   <hr>
   <!--刪除留言-->
   <form action="del.php" method="post"> 要刪除留言的暱稱 :  <input type="text" name="del_name" />
　    <input type="submit" value="刪除留言"/><p><hr>
   </form>
   <!--修改留言-->
   <form method = "post" action = "modify.php">
      修改留言<p>
      要修改留言的暱稱:<br>
      <input type = "text" name = "mod_name"><p>
         要修改的留言:<br>
      <textarea rows="10" cols="20" name="mod_content"></textarea><br>
      <input type = "submit" value="修改留言" /><p><hr>
   </form>
  <!--返回留言版 -->
   <input type="button" name="Submit" value="返回留言版" class="btn" onclick="location.href='index.html'" /><p>
</form>
</body>
</html>

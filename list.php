<!doctype html>
<html>
<head><title>顯示資料</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
require_once  "pdo.php";

#$tis = $conn->query('SELECT * FROM msg');
$tis = $conn->query('SELECT * FROM msg');

echo "<h2>留言內容 </h2>";
echo "<p>";
while ($row = $tis->fetch()) {
        echo '<form method="post" action="reply.php">';
	echo "留言者: " . $row['name'] ." 留言ID : " . $row['id'] . "<br>" .  "留言 : " . $row['descr'] . "<br>" .
	'<input type="hidden" name="reply_id" value="' . $row['id'] .'">' .
        '<input type="text" name="reply_message">' .
        '<input type="submit" name="send" value="回覆">' .	
        "<hr>";
        echo '</form>';
}

?>
   <form method = "post" action = "modify.php">
      <h2>修改留言</h2><p>
      要修改留言的ID:<br>
      <input type = "text" name = "mod_id"><p>
         要修改的留言:<br>
      <textarea rows="10" cols="20" name="mod_content"></textarea><br>
      <input type = "submit" value="修改留言" /><p><hr>
   </form>
   <input type="button" name="Submit" value="返回留言版" class="btn" onclick="location.href='index.html'" />
   <input type="button" name="Submit" value="查詢留言" class="btn" onclick="location.href='list.php'" /><p>
    <!--刪除留言-->
   <form action="del.php" method="post"> 要刪除留言的ID :  <input type="text" name="del_id" />
　    <input type="submit" value="刪除留言"/><p>
   </form>
   <p>
</body>
</html>

<!doctype html>
<html>
<head><title>顯示資料</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
require_once  "pdo.php";

$query = "SELECT * FROM msg";
$tis = $conn->prepare($query);
$tis->execute();

echo "<h2>留言內容 </h2>";
echo "<p>";
while ($row = $tis->fetch()) {
    echo '<div>';
    echo '<form method="post" action="reply.php">';
    echo '留言者: ' . $row['name'] .' 留言ID : ' . $row['id'] . "<br>" .  "留言 : " . $row['descr'] . "<br>" .
        '<input type="hidden" name="reply_id" value="' . $row['id'] .'">' .
        '<input type="text" name="reply_message">' .
        '<input type="submit" name="send" value="回覆">' .
        '<p>';
    echo '</form>';
    $msg_id = $row['id'];
    $query2 = "SELECT message, id FROM reply WHERE `msg_id` = ?";
    $tis2 = $conn->prepare($query2);
    $tis2->bindParam(1, $msg_id);
    $tis2->execute();
    while ($row2 = $tis2->fetch()) {
        echo '<form method="post" action="del-replat.php">';
	echo '留言回覆 : ' . $row2['message'] . '&emsp;' .
	    '<input type="hidden" name="del_re_message" value="' . $row2['message'] . '">' .
	    '<input type="hidden" name="del_re_id" value="' . $row2['id'] . '">' .
	    '<input type="submit" name="send" value="刪除回覆">';
	echo '</form>';
	echo '</div>';
    }
    echo '<hr><br>';
}

?>
   <form method = "post" action = "modify.php" name="chk_mod" onsubmit="return check_mod()">
      <h2>修改留言</h2><p>
      要修改留言的ID:<br>
      <input type = "text" name = "mod_id"><p>
         要修改的留言:<br>
      <textarea rows="10" cols="20" name="mod_content"></textarea><br>
      <input type = "submit" value="修改留言" /><p><hr>
   </form>
   <input type="button" name="Submit" value="返回留言版" class="btn" onclick="location.href='index.html'" />
   <input type="button" name="Submit" value="查詢留言" class="btn" onclick="location.href='list.php'" /><p>
   <form action="del.php" method="post" name="chk_del" onsubmit="return check_del()"> 
       要刪除留言的ID :  
       <input type="text" name="del_id" />
　     <input type="submit" value="刪除留言"/><p>
   </form>
   <p>
</body>
<script type="text/javascript">
    function check_mod(){
        if(chk_mod.mod_id.value == "") {
            alert("未輸入修改ID");
            return false;
        }else
            chk_mod.submit();
        }
    function check_del(){
        if(chk_del.del_id.value == "") {
            alert("未輸入刪除ID");
            return false;
        }else
            chk_del.submit();
        }
</script>
</html>

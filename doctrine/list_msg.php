<!doctype html>
<html>

<head>
    <title>顯示資料</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>


    <?php
    // list_msg.php
    require_once "bootstrap.php";

    $msgRepository = $entityManager->getRepository('Msg');
    $msg = $msgRepository->findAll();

    foreach ($msg as $msg) {
        echo '<div>';
        echo '<form method="post" action="reply.php">';
        echo '留言者: ' . $msg->getName() . ' 留言ID : ' . $msg->getID() . "<br>" .  "留言 : " . $msg->getDescr() . "<br>" .
            '<input type="hidden" name="reply_id" value="' . $msg->getID() . '">' .
            '<input type="text" name="reply_message">' .
            '<input type="submit" name="send" value="回覆">' .
            '<p>';
        echo '</form>';
        echo '<hr><br>';
        
        // echo $msg->getID() . '<br>';
        // echo sprintf("-%s\n", $msg->getID());
        // echo sprintf("-%s\n", $msg->getName());
        // echo sprintf("-%s\n", $msg->getDescr());
    }
    ?>

    <form method="post" action="update_msg.php" name="chk_mod" onsubmit="return check_mod()">
        <h2>修改留言</h2>
        <p>
            要修改留言的ID:<br>
            <input type="text" name="mod_id">
            <p>
                要修改的留言:<br>
                <textarea rows="10" cols="20" name="mod_content"></textarea><br>
                <input type="submit" value="修改留言" />
                <p>
                    <hr>
    </form>
    <input type="button" name="Submit" value="返回留言版" class="btn" onclick="location.href='index.html'" />
    <input type="button" name="Submit" value="查詢留言" class="btn" onclick="location.href='list_msg.php'" />
    <p>
        <form action="remove_msg.php" method="post" name="chk_del" onsubmit="return check_del()">
            要刪除留言的ID :
            <input type="text" name="del_id" />
            　 <input type="submit" value="刪除留言" />
            <p>
        </form>
        <p>
</body>
<script type="text/javascript">
    function check_mod() {
        if (chk_mod.mod_id.value == "") {
            alert("未輸入修改ID");
            return false;
        } else
            chk_mod.submit();
    }

    function check_del() {
        if (chk_del.del_id.value == "") {
            alert("未輸入刪除ID");
            return false;
        } else
            chk_del.submit();
    }
</script>

</html>
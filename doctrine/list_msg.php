<!doctype html>
<html>

<head>
    <title>顯示資料</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>


    <?php
    require_once "bootstrap.php";

    $msgRepository = $entityManager->getRepository('Msg');
    $msg = $msgRepository->findAll();

    echo '<p><hr><p>';
    $qb->select($qb->expr()->count('id'))
        ->from('Msg','id');
    $query = $qb->getQuery();
    $msgCount = $query->getSingleScalarResult();
    echo "目前留言總筆數有 : " . $msgCount . "筆";
    echo '<p><hr><p>';


    foreach ($msg as $msg) {
        echo '<form method="post" action="creat_reply.php">';
        echo '留言者: ' . $msg->getName() . ' 留言ID : ' . $msg->getID() . "<br>" .  "留言 : " . $msg->getDescr() . "<br>" .
            '<input type="hidden" name="reply_id" value="' . $msg->getID() . '">' .
            '<input type="text" name="reply_message">' .
            '<input type="submit" name="send" value="回覆">' .
            '<p>';
        echo '</form>';

        $replyId = $msg->getID();
        $replyRepository = $entityManager->getRepository('Reply');
        $reply = $replyRepository->findBy(array('msg' => $replyId));

        foreach ($reply as $reply) {
            echo '<form method="post" action="remove_reply.php">';
            echo '留言回覆 : ' . $reply->getMessage() . '&emsp;' .
                '<input type="hidden" name="del_re_id" value="' . $reply->getId() . '">' .
                '<input type="submit" name="send" value="刪除回覆">';
            echo '</form>';
        }
        echo '<hr><br>';
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
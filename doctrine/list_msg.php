<!doctype html>
<html>

<head>
    <title>顯示資料</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <form method="post" action="update_msg.php" name="chk_mod" onsubmit="return check_mod()">
        <h2>修改留言</h2>
        <p>
            要修改留言的ID:<br>
            <input type="text" name="mod_id">
            <p>
                要修改的留言:<br>
                <textarea rows="1" cols="20" name="mod_content"></textarea><br>
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
            <hr>
            <form action="batch_del_msg.php" method="post" name="chk_batch_del" onsubmit="return batch_del()">
                要刪除批次留言的姓名 :
                <input type="text" name="batch_del_name" />
                　 <input type="submit" value="批次刪除留言" />
                <p>
            </form>


            <?php
            require_once "bootstrap.php";

            $msgCount = $entityManager->getRepository('Msg')->count([]);
            echo '目前留言總筆數有 : <font color="red">' . $msgCount . '</font> 筆';
            echo '<br><hr><p>';

            // 每頁筆數
            $per = 5;
            // 計算頁數
            $pages = ceil($msgCount / $per);
            // 獲取當前頁碼
            if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
                $page = 1; //則在此設定起始頁數
            } else {
                $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
            }
            $start = ($page - 1) * $per; //每一頁開始的資料序號

            $msgRepository = $entityManager->getRepository('Msg');
            $msg = $msgRepository->findBy(array(), array(), $per, $start);

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
                echo '<hr>';
            }

            //顯示分頁
            for ($i = 1; $i <= $pages; ++$i) {
                echo '<a href="?page=' . $i . '">' . $i . '</a> ';
            }
            ?>
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

    function batch_del() {
        if (chk_batch_del.batch_del_name.value == "") {
            alert("未輸入批次刪除姓名");
            return false;
        } else
            chk_batch_del.submit();
    }
</script>

</html>
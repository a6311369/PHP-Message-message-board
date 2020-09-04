<?php
require_once "bootstrap.php";

$stime = microtime(true);
$del_Name = trim($_POST['batch_del_name']);

$msgRepository = $entityManager->getRepository('Msg');
$msg = $msgRepository->findBy(array('name' => $del_Name));
foreach ($msg as $msg) {
    $entityManager->remove($msg);
}
$entityManager->flush();

$etime = microtime(true);
$total = $etime - $stime;
echo "<br />批次執行時間為：{$total} 秒<p>";

require_once "list_msg.php";

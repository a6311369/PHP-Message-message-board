<?php
require_once "bootstrap.php";

$newName = trim($_POST['bname']);
$newNumber = trim($_POST['bnumber']);
$newDescr = trim($_POST['bcontent']);
$stime=microtime(true); 

for ($i = 1; $i <= $newNumber; ++$i) {
    $bname = $newName;
    $bdescr = '第' . $i . '次留言 : ' . $newDescr;
    $msg = new Msg();
    $msg->setName($bname);
    $msg->setDescr($bdescr);
    $entityManager->persist($msg);
}
$entityManager->flush();
$etime=microtime(true);
$total=$etime-$stime;

echo "<h3> 批次留言成功 </h3>";
echo "<br />批次執行時間為：{$total} 秒<p>";


require_once "index.html";

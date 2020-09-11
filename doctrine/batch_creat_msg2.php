<?php
require_once "bootstrap.php";

$stime = microtime(true);

$batchSize = 2000;
for ($i = 1; $i <= 10000; ++$i) {
    $msg = new Msg;
    $msg->setName('user' . $i);
    $msg->setDescr('Mr.Smith-' . $i);
    $entityManager->persist($msg);
    if (($i % $batchSize) === 0) {
        $entityManager->flush();
        $entityManager->clear(); // Detaches all objects from Doctrine!
    }
}
$entityManager->flush(); //Persist objects that did not make up an entire batch
$entityManager->clear();

$etime = microtime(true);
$total = $etime - $stime;

echo "<h3> 批次留言成功 </h3>";
echo "<br />批次執行時間為：{$total} 秒<p>";


require_once "index.html";

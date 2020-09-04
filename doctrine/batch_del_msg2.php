<?php
require_once "bootstrap.php";
$stime = microtime(true);


$batchSize = 2000;
$i = 1;
$q = $entityManager->createQuery('select m from Msg m');
$iterableResult = $q->iterate();
while (($row = $iterableResult->next()) !== false) {
    $entityManager->remove($row[0]);
    if (($i % $batchSize) === 0) {
        $entityManager->flush();
        $entityManager->clear();
    }
    ++$i;
}
$entityManager->flush();

$etime = microtime(true);
$total = $etime - $stime;
echo "<br />批次執行時間為：{$total} 秒<p>";

require_once "index.html";
// require_once "list_msg.php";

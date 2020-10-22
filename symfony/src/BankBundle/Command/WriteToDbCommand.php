<?php

namespace BankBundle\Command;

use BankBundle\Entity\Bank;
use BankBundle\Entity\BankDetail;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



class WriteToDbCommand extends ContainerAwareCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:writetodb';

    protected function configure()
    {
        $this
            ->setDescription('Redis Write To DB.')
            ->setHelp('This command allows you to Redis Write To DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $redis = $this->getContainer()->get('snc_redis.default');
        $doctrine = $this->getContainer()->get('doctrine');
        $entityManager = $doctrine->getManager();

        $count = $redis->LLEN('id');
        $count = (int)$count;
        for ($i = 0; $i < $count; $i++) {
            $id = $redis->LINDEX('id', $i);
            $bank = $entityManager->find('BankBundle:Bank', $id);
            $bankId = 'accountId' . $id;
            $bankMoney = $redis->GET($bankId);
            $balance = (int)$bankMoney;
            $bank->setMoney($balance);
            $entityManager->persist($bank);
            $entityManager->flush();
            $entityManager->clear();
        }

        //insert BankDetail
        $bankDetail = new BankDetail();
        for ($j = 0; $j < $count; $j++) {
            $id = $redis->LINDEX('id', $j);
            $detaiUser = 'detailNum:Id:' . $id;
            $detailNum = $redis->GET($detaiUser);
            $detailNum = (int)$detailNum;
            if ($detailNum != 0) {
                for ($k = 1; $k <= $detailNum; $k++) {
                    //redis取值
                    $detailNotes = $redis->rpop('detailNotes:Id:' . $id);
                    $detailModmoney = $redis->rpop('detailModmoney:Id:' . $id);
                    $detailOldmoney = $redis->rpop('detailOldmoney:Id:' . $id);
                    $detailNewmoney = $redis->rpop('detailNewmoney:Id:' . $id);
                    $detaildate = $redis->rpop('detaildate:Id:' . $id);

                    //寫入DB
                    $bankDetail->setNotes($detailNotes);
                    $bankDetail->setUserId($id);
                    $bankDetail->setModifyMoney($detailModmoney);
                    $bankDetail->setOldMoney($detailOldmoney);
                    $bankDetail->setNewMoney($detailNewmoney);
                    $bankDetail->setCreatedTime($detaildate);

                    $entityManager->persist($bankDetail);
                    $entityManager->flush();
                    $entityManager->clear();
                }
                $redis->DEL($detaiUser);
                $redis->DEL('detailID:' . $id);
            }
        }

        $output->writeln('Redis Write To DB Finsh.');
    }
}

<?php

namespace BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="bankdetail")
 */
class BankDetail
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $notes;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $userName;
    /**
     * @ORM\Column(type="integer")
     */
    protected $modifyMoney;
    /**
     * @ORM\Column(type="integer")
     */
    protected $oldMoney;
    /**
     * @ORM\Column(type="integer")
     */
    protected $newMoney;

    /**
    *  @ORM\Column(type="string", length=100)
    */
    protected $createdTime;

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getModifyMoney()
    {
        return $this->modifyMoney;
    }

    public function setModifyMoney($modifyMoney)
    {
        $this->modifyMoney = $modifyMoney;
    }

    public function getOldMoney()
    {
        return $this->oldMoney;
    }

    public function setOldMoney($oldMoney)
    {
        $this->oldMoney = $oldMoney;
    }

    public function getNewMoney()
    {
        return $this->newMoney;
    }

    public function setNewMoney($newMoney)
    {
        $this->newMoney = $newMoney;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

}

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

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

}

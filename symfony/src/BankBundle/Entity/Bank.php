<?php

namespace BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="bank")
 */
class Bank
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
    protected $user;
    /**
     * @ORM\Column(type="integer")
     */
    protected $money;

    public function getMoney()
    {
        return $this->money;
    }

    public function setMoney($money)
    {
        $this->money = $money;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}

<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reply")
 */
class Reply
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $msg_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $message;

    public function getId()
    {
        return $this->id;
    }

    public function getMsg_id()
    {
        return $this->name;
    }

    public function setMsg_id($Msg_id)
    {
        $this->name = $name;
    }


    public function getmessage()
    {
        return $this->descr;
    }

    public function setmessage($message)
    {
        $this->descr = $descr;
    }

}


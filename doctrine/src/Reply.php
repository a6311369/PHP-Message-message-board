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
     * @ORM\Column(type="integer")
     */
    protected $msgId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $message;

    public function getId()
    {
        return $this->id;
    }

    public function getMsgId()
    {
        return $this->msgId;
    }

    public function setMsgId($msgId)
    {
        $this->msgId = $msgId;
    }


    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

}


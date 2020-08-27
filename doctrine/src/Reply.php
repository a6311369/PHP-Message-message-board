<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

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
     * @ORM\ManyToOne(targetEntity="Msg", inversedBy="replies", cascade={"persist"})
     * @ORM\JoinColumn(name="msgid_id", referencedColumnName="id")
     */
    private $msgid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $message;

    public function getId()
    {
        return $this->id;
    }

    public function getMsgid()
    {
        return $this->msgid;
    }

    public function setMsgid($msgid)
    {
        $this->msgid = $msgid;
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

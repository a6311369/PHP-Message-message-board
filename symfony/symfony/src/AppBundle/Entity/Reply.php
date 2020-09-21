<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Msg", inversedBy="replies")
     * @ORM\JoinColumn(name="msg_id", referencedColumnName="id")
     */
    private $msg;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $message;
    /**
     * @ORM\Column(type="integer")
     */
    protected $num;

    public function getId()
    {
        return $this->id;
    }

    public function getnum()
    {
        return $this->num;
    }

    public function setnum($num)
    {
        $this->num = $num;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg(Msg $msg = null)
    {
        $this->msg = $msg;
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

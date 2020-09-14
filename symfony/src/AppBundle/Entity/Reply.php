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
     * @ORM\Column(type="integer")
     */
    protected $id2;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Msg", inversedBy="replies", cascade={"persist"})
     * @ORM\JoinColumn(name="msg_id", referencedColumnName="id")
     */
    private $msg;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $message;

    public function getId()
    {
        return $this->id;
    }

    public function getId2()
    {
        return $this->id2;
    }

    public function setId2($id2)
    {
        $this->id2 = $id2;
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

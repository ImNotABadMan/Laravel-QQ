<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-12
 * Time: 22:32
 */

namespace App\Lib\PHPImap;


class Message implements MessageInterface
{
    private $_connection;

    private $_date;

    private $_size;

    private $_messageNo;

    private $_messageID;

    private $_uID;

    private $_subject;

    private $_from;

    private $_to;

    private $_references;

    private $_inReplyTo;

    /**
     * @throws
    */
    public function __construct($connection)
    {
        $this->_date = new \DateTime('now');

        if(!is_resource($connection)){
            throw new \InvalidArgumentException('Connection Is Not A Resource');
        }

        $this->_connection = $connection;
    }

    /**
     * @return MessageInterface
    */
    public function setDate(string $date): MessageInterface
    {
        // TODO: Implement setDate() method.
        $this->_date = $date;
        return $this;
    }

    public function getDate(): \DateTime
    {
        // TODO: Implement getDate() method.
        return $this->_date;
    }

    /**
     * @return MessageInterface
    */
    public function setSize(int $size) : MessageInterface
    {
        // TODO: Implement setSize() method.
        $this->_size = $size;
        return $this;
    }

    public function getSize(): int
    {
        // TODO: Implement getSize() method.
        return $this->_size;
    }

    public function getSubject(): string
    {
        // TODO: Implement getSubject() method.
        return $this->_subject;
    }

    public function setSubject(string $subject) : MessageInterface
    {
        // TODO: Implement setSubject() method.
        $this->_subject = $subject;
        return $this;
    }

    public function getFrom(): string
    {
        // TODO: Implement getFrom() method.
        return $this->_from;
    }

    public function setFrom(string $form) : MessageInterface
    {
        // TODO: Implement setFrom() method.
        $this->_from = $form;
        return $this;
    }

    public function getInReplyTo(): string
    {
        // TODO: Implement getInReplyTo() method.
        return $this->_inReplyTo;
    }

    public function setInReplyTo(string $replyTo) : MessageInterface
    {
        // TODO: Implement setInReplyTo() method.
        $this->_inReplyTo = $replyTo;
        return $this;
    }

    public function getMessageID(): string
    {
        // TODO: Implement getMessageID() method.
        return $this->_messageID;
    }

    public function setMessageID(string $id) : MessageInterface
    {
        // TODO: Implement setMessageID() method.
        $this->_messageID = $id;
        return $this;
    }

    public function getMessageNo(): string
    {
        // TODO: Implement getMessageNo() method.
        return $this->_messageNo;
    }

    public function setMessageNo(int $messageNo) : MessageInterface
    {
        // TODO: Implement setMessageNo() method.
        $this->_messageNo = $messageNo;
        return $this;
    }

    public function getReferences(): string
    {
        // TODO: Implement getReference() method.
        return $this->_references;
    }

    public function setReferences(string $references) : MessageInterface
    {
        // TODO: Implement setReference() method.
        $this->_references = $references;
        return $this;
    }


    public function getTo(): string
    {
        // TODO: Implement getTo() method.
        return $this->_to;
    }

    public function setTo(string $to) : MessageInterface
    {
        // TODO: Implement setTo() method.
        $this->_to = $to;
        return $this;
    }


    public function getUID(): string
    {
        // TODO: Implement getUID() method.
        return $this->_uID;
    }


    public function setUID(string $uid) : MessageInterface
    {
        // TODO: Implement setUID() method.
        $this->_uID = $uid;
        return $this;
    }

    /**
     * 识别邮件类型并解析
    */
    public function fetch(int $option = 0) : self
    {
        $structure = imap_fetchstructure($this->_connection, $this->getMessageNo(), $option);

        if(empty($structure)){
            return $this;
        }

        switch ($structure->type){
            case TYPEMULTIPART:
            case TYPETEXT:
                $this->processStruct($structure);
                break;
            case TYPEMESSAGE:
                break;
            case TYPEAPPLICATION:
            case TYPEAUDIO:
            case TYPEIMAGE:
            case TYPEVIDEO:
            case TYPEMODEL:
            case TYPEOTHER:
                break;
        }

        return $this;
    }

    public function processStruct($structure)
    {

    }

}

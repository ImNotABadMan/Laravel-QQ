<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-13
 * Time: 22:35
 */

namespace App\Lib\PHPImap;


interface MessageInterface
{
    public function __construct($connection);

    public function getSubject() : string;

    public function setSubject(string $subject) : MessageInterface ;

    public function getFrom() : string ;

    public function setFrom(string $form) : MessageInterface ;

    public function setTo(string $to) : MessageInterface ;

    public function getTo() : string ;

    public function setDate(string $date) : MessageInterface ;

    public function getDate() : \DateTime;

    public function setMessageID(string $id) : MessageInterface ;

    public function getMessageID() : string ;

    public function getReferences() : string ;

    public function setReferences(string $references) : MessageInterface ;

    public function setInReplyTo(string $replyTo) : MessageInterface ;

    public function getInReplyTo() : string ;

    public function setSize(int $size) : MessageInterface ;

    public function getSize() : int ;

    public function getUID() : string ;

    public function setUID(string $uid) : MessageInterface ;

    public function setMessageNo(int $messageNo) : MessageInterface ;

    public function getMessageNo() : string ;

    public function getConnection();

    public function setConnection($connection) : MessageInterface ;
}

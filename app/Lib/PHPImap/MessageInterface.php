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

    public function setSubject(string $subject) : self ;

    public function getFrom() : string ;

    public function setFrom(string $form) : self ;

    public function setTo(string $to) : self ;

    public function getTo() : string ;

    public function setDate(string $date) : self ;

    public function getDate() : \DateTime;

    public function setMessageID(string $id) : self ;

    public function getMessageID() : string ;

    public function getReferences() : string ;

    public function setReferences(string $references) : self ;

    public function setInReplyTo(string $replyTo) : self ;

    public function getInReplyTo() : string ;

    public function setSize(int $size) : self ;

    public function getSize() : int ;

    public function getUID() : string ;

    public function setUID(string $uid) : self ;

    public function setMessageNo(int $messageNo) : self ;

    public function getMessageNo() : string ;

}

<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-12
 * Time: 22:32
 */

namespace App\Lib\PHPImap;


use Carbon\Carbon;

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

    // 附件
    private $_attachment;

    // 邮件内容--文本
    private $_plainBody;

    // 邮件内容--html
    private $_htmlBody;
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

    private function _changeEncoding($str)
    {
        if($str) {
            // 判断编码
            $encode = mb_detect_encoding($str, array("ASCII", "UTF-8", "GB2312", "GBK", "BIG5", "CP936", "ISO-8859-1"), "auto");
            switch ($encode) {
                case 'EUC-CN':
                case 'GB2312':
                case 'GBK':
                    $str = iconv('GBK', 'UTF-8', $str);
                    break;
                case "CP936":
                case "ISO-8859-1":
                    if(request('type') == 'gmail'){
//                        $str = trim(trim(rtrim(ltrim($str, 'b'), 'E'),"\""));
                    }
                    $str = iconv('ISO-8859-1', 'UTF-8', $str);
                    break;
            }
        }
        return $str;
    }

    public function getConnection()
    {
        // TODO: Implement getConnection() method.
        return $this->_connection;
    }

    public function setConnection($connection): MessageInterface
    {
        // TODO: Implement setConnection() method.
        if(!is_resource($connection)){
            throw new \InvalidArgumentException('Connection is Not a resource');
        }
        $this->_connection = $connection;
        return $this;
    }

    /**
     * @return MessageInterface
    */
    public function setDate(string $date): MessageInterface
    {
        // TODO: Implement setDate() method.
        $this->_date = ($date instanceof \DateTime) ?
            $date :
            new Carbon(date('Y-m-d H:i:s', strtotime($date)));
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
        // 需要解码
        $this->_subject = base64_decode(str_replace(['=?GBK?B?', '=?UTF8?B?', '?='],'', $subject));
        $this->_subject = $this->_changeEncoding($this->_subject);
        return $this;
    }

    public function getFrom(): string
    {
        // TODO: Implement getFrom() method.
        return $this->_from;
    }

    public function setFrom(string $from) : MessageInterface
    {
        // TODO: Implement setFrom() method.
        $prefix = strstr($from, '<', true);
        $fromMail = str_replace($prefix, '', $from);
        $prefix = str_replace(['=?GBK?B?', '=?UTF8?B?', '?='],'', $prefix);
        $position = strpos($prefix, '=');
        if($position){
            $prefix = substr($prefix, 0,  $position);
        }
        $prefix .= '==';
        $base64 = base64_decode($prefix);
        $prefix = $this->_changeEncoding($base64);
        $this->_from = $prefix . $fromMail;
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
//        dd($structure);

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

    /**
     * 解析邮件内容
    */
    protected function processStruct($structure, $partID = null)
    {
        $params = [];
        $self = $this;
        // 匿名函数，解析成树结构
        $resource = function ($struct) use ($self, $partID){
            if(isset($struct->parts) && is_array($struct->parts)){
                foreach ($struct->parts as $ids => $part){
                    $currentID = $ids + 1;
                    if( !is_null($partID) ){
                        $currentID = $partID . '.' . $currentID;
                    }

                    $self->processStruct($part, $currentID);
                }
            }
            return $self;
        };

        if( isset($structure->parameters) ){
            foreach ($structure->parameters as $parameter){
                $params[strtolower($parameter->attribute)] = $parameter->value;
            }
        }
        if(isset($structure->dparameters)){
            foreach ($structure->dparameters as $dparameter){
                $params[strtolower($dparameter->attribute)] = $dparameter->value;
            }
        }

        // 判断是什么类型，再根据类型解析
        if(isset($params['name']) || isset($params['filename']) ||
            (isset($structure->subtype) && strtolower($structure->subtype) == 'rfc822')
        ){
            // Process attachment
            $filename = isset($params['name']) ? $params['name'] : $params['filename'];
            $attachment = new Attachment($this);
            $attachment->setSize($structure->bytes)
                ->setEncoding($structure->encoding)
                ->setFilename($filename)
                ->setPartID($partID);

            switch ($structure->type){
                case TYPETEXT:
                    $mineType = 'text';
                    break;
                case TYPEMESSAGE:
                    $mineType = 'message';
                    break;
                case TYPEAPPLICATION:
                    $mineType = 'application';
                    break;
                case TYPEAUDIO:
                    $mineType = 'audio';
                    break;
                case TYPEVIDEO:
                    $mineType = 'video';
                    break;
                case TYPEIMAGE:
                    $mineType = 'image';
                    break;
                case TYPEOTHER:
                default:
                    $mineType = 'other';
                    break;
            }

            $mineType .= '/' . $structure->subtype;
            $attachment->setMineType($mineType);
            $this->_attachment[$partID] = $attachment;

            //递归根节点为attachment类型的$resource，看看有没有子节点
            return $resource($structure);
        }

        if(!is_null($partID)){
            $body = imap_fetchbody($this->_connection, $this->getMessageNo(), $partID, FT_PEEK);
        }else{
            $body = imap_body($this->_connection, $this->getUID(), FT_UID | FT_PEEK);
        }

        $encoding = strtolower($structure->encoding);

        switch ($encoding){
            case 'quoted-printable':
            case ENCQUOTEDPRINTABLE:
                $body = quoted_printable_decode($body);
                break;
            case 'base64':
            case ENCBASE64:
                $body = base64_decode($body);
                break;
        }

        $subtype = strtolower($structure->subtype);

        switch (true){
            case $subtype == 'plain':
                if(!empty($this->_plainBody)){
                    $this->_plainBody .= PHP_EOL . PHP_EOL . trim($body);
                }else{
                    $this->_plainBody = $body;
                }
                break;
            case $subtype == 'html':
                if (!empty($this->_htmlBody)){
                    $this->_htmlBody .= nl2br("\n\n") . $body;
                }else{
                    $this->_htmlBody = $body;
                }
                break;
        }

        return $resource($structure);
    }

}

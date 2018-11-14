<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-12
 * Time: 22:32
 */

namespace App\Lib\PHPImap;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Client
{
    private $_currentMailbox = '';
    private $_spec = [];
    private $_connection = null;
    private $_prototype = null;

    /**
     * @throws
    */
    public function __construct($connection, array $spec = [])
    {
        if(!is_resource($connection)){
            throw new \InvalidArgumentException('Connection Argument Not A Resource');
        }

        $this->_connection = $connection;
        $this->_prototype = new Message($connection);
        $this->_spec = $spec;
        $this->_currentMailbox = $spec['mailbox'];
    }

    public function setPrototype(MessageInterface $message) : self
    {
        $this->_prototype = $message;
        return $this;
    }

    /**
     * @return MessageInterface
    */
    public function getPrototype() : MessageInterface
    {
        return clone $this->_prototype;
    }

    /**
     * @throws
     * 改变当前客户端
    */
    public function setCurrentMailbox(string $mailbox, int $option = 0,
                                      int $n_retries = 0) : self
    {
        $this->_currentMailbox = $mailbox;

        if(!imap_reopen($this->_connection,
            $this->getServerRef() . $this->_currentMailbox,
            $option, $n_retries)
        ){
            throw new ImapException("Failed to open mail: {$mailbox}");
        }

        return $this;
    }

    /**
     * 得到当前客户端
    */
    public function getCurrentMailbox() : string
    {
        return $this->_currentMailbox;
    }

    /**
     * @throws \Exception
    */
    public function getServerRef() : string
    {
        if( empty($this->_spec['hostname']) ){
            throw new \Exception("Hostname is null");
        }

        $serverRef = "{" . $this->_spec['hostname'];

        if(!empty($this->_spec['port'])){
            $serverRef .= ':' . $this->_spec['port'];
        }
        if (!empty($this->_spec['path'])){
            $serverRef .= $this->_spec['path'];
        }

        $serverRef .= '}';

        return $serverRef;
    }

    /**
     * @throws
    */
    public function getMailboxes($pattern = '*')
    {
        $serverRef = $this->getServerRef();
        $list = imap_list($this->_connection, $this->getServerRef(), $pattern);

        if (!is_array($list)){
            return [];
        }

        foreach ($list as $mailbox) {
            $returnVal[] = str_replace($serverRef, '', $mailbox);
        }

        return $returnVal ?? [];
    }

    /**
     * 获取邮件列表
     * @return
    */
    public function getPage(int $page = 1, int $perPage = 25,
                            $option = 0) : Collection
    {
        $boxInfo = imap_check($this->_connection);
        $start = $boxInfo->Nmsgs - ($perPage * $page);
        $end = $start + ($perPage - (($page > 1) ? 1 : 0));

        if($start < 1){
            $start = 1;
        }

        $list = imap_fetch_overview($this->_connection, "{$start}:{$end}", $option);

        $list = array_reverse($list);

        $collection = new Collection();

        foreach ($list as $key => $item) {
            $message = $this->getPrototype();

            $message->setFrom($item->from)
                ->setTo($item->to)
                ->setDate($item->date)
                ->setSubject($item->subject)
                ->setMessageNo($item->msgno)
                ->setSize($item->size)
                ->setUID($item->uid);

            if(!empty($item->message_id)){
                $message->setMessageID($item->message_id);
            }

            if(!empty($item->references)){
                $message->setReferences($item->references);
            }

            if(!empty($item->in_reply_to)){
                $message->setInReplyTo($item->in_reply_to);
            }

            $collection->put($key, $message);

        }

        return $collection;
    }

    /**
     * 获得单个Message
     * @return MessageInterface
    */
    public function getMessage($id, int $option = 0) : MessageInterface
    {
        $overview = imap_fetch_overview($this->_connection, $id, $option);

        if(!empty($overview)){
            $overview = array_pop($overview);
        }

        $message = $this->getPrototype();

        $message->setFrom($overview->from)
            ->setTo($overview->to)
            ->setDate($overview->date)
            ->setSubject($overview->subject)
            ->setMessageNo($overview->msgno)
            ->setSize($overview->size)
            ->setUID($overview->uid);

        if(!empty($item->message_id)){
            $message->setMessageID($item->message_id);
        }

        if(!empty($overview->references)){
            $message->setReferences($overview->references);
        }

        if(!empty($overview->in_reply_to)){
            $message->setInReplyTo($overview->in_reply_to);
        }

        return $message;
    }

}

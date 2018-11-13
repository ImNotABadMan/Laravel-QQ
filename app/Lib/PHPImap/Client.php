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
        $this->_prototype = new Message();
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

        $collection = new Collection($list);

        return $collection;
    }

}

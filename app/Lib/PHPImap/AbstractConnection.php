<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-12
 * Time: 22:23
 */

namespace App\Lib\PHPImap;


abstract class AbstractConnection
{
    protected $_username;
    protected $_password;

    protected $hostname = '';
    protected $port = 993;
    protected $path = '/imap/ssl';
    protected $mailbox = 'INBOX';

    public function getUsername() : string
    {
        return $this->_username;
    }

    public function getPassword() : string
    {
        return $this->_password;
    }

    public function setUsername($username) : self
    {
        $this->_username = $username;
        return $this;
    }

    public function setPassword($password) : self
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * 连接imap，并获得客户端
     * @return Client
     * @throws
    */
    public function connect(int $option = 0, int $n_retries = 0,
                            array $params = []) : Client
    {
        $connection = imap_open(
            $this->getServerRef(),
            $this->getUsername(),
            $this->getPassword(),
            $option,
            $n_retries,
            $params
        );
        if(!is_resource($connection)){
            throw new \Exception('Failed to connect ti server');
        }

        return new Client();
    }

    public function getServerDetails() : array
    {
        return [
            'hostname' => $this->hostname,
            'port' => $this->port,
            'path' => $this->path,
            'mailbox' => $this->mailbox
        ];
    }

    /**
     * @throws
    */
    public function getServerRef() : string
    {
        // 前提
        if(is_null($this->hostname)){
            throw new \Exception('No Hostname provided');
        }

        $serverRef = '{' . $this->hostname;
        if( !empty($this->port) ){
            $serverRef .= ':' . $this->port;
        }

        if(!empty($this->path)){
            $serverRef =  $this->path;
        }

        $serverRef .= '}' . $this->mailbox;

        return $serverRef;
    }
}

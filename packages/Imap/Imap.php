<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-05
 * Time: 23:23
 */

namespace Packages\Imap;


class Imap
{
    private $_user;
    private $_password;
    private $_iMapServer;
    private $_iMapPort;
    private $_iMapUrl;

    private $_iMap;

    public function __construct()
    {
        switch (env('IMAP_DRIVER')){
            case 'qq':
                $server = config('imap.qq.server');
                $user = config('imap.qq.user');
                $password = config('imap.qq.password');
                break;
            case 'gmail':
                $server = config('imap.gmail.server');
                $user = config('imap.gmail.user');
                $password = config('imap.gmail.password');
                break;
            default:
                $server = config('imap.qq.server');
                $user = config('imap.qq.user');
                $password = config('imap.qq.password');
                break;
        }
        $this->_user = $user;
        $this->_password = $password;
        $this->_iMapServer = $server;
        $this->_iMapPort = '993';
        $this->_iMapUrl = "{{$this->_iMapServer}:{$this->_iMapPort}/imap/ssl}INBOX";
        $this->_iMap = imap_open($this->_iMapUrl, $this->_user, $this->_password);
//        dump($this);

        // 邮箱客户端
        // imap 接收 imao.qq.com 993
        //账户名：您的QQ邮箱账户名（如果您是VIP帐号或Foxmail帐号，账户名需要填写完整的邮件地址）
        //密码：您的QQ邮箱密码
        //电子邮件地址：您的QQ邮箱的完整邮件地址
        // smtp 发送 smtp.qq.com 465或587
    }

    public function iMapList() : array
    {
        return imap_list($this->_iMap, $this->_iMapUrl, "*");
    }

    public function iMapFetch(int $start, int $end) : array
    {
        return imap_fetch_overview($this->_iMap, "{$start}:{$end}");
    }

    public function iMapCheck()
    {
        return imap_check($this->_iMap);
    }

    public function iMapBody(int $messageID) : string
    {
        return imap_body($this->_iMap, $messageID);
    }

    public function iMapStruct(int $messageID) : \stdClass
    {
        return imap_fetchstructure($this->_iMap, $messageID);
    }

}

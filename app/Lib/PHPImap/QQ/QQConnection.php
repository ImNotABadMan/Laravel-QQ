<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-13
 * Time: 23:43
 */

namespace App\Lib\PHPImap\QQ;


use App\Lib\PHPImap\AbstractConnection;

class QQConnection extends AbstractConnection
{
    protected $hostname = 'imap.qq.com';
    protected $port = 993;
    protected $path = '/imap/ssl';
    protected $mailbox = 'INBOX';
}

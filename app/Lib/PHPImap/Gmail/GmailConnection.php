<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-12
 * Time: 22:32
 */

namespace App\Lib\PHPImap\Gmail;


use App\Lib\PHPImap\AbstractConnection;

class GmailConnection extends AbstractConnection
{
    protected $hostname = 'imap.gmail.com';
    protected $port = 993;
    protected $path = '/imap/ssl';
    protected $mailbox = 'INBOX';

}

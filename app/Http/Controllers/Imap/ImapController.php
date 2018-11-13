<?php

namespace App\Http\Controllers\Imap;

use App\Lib\PHPImap\Client;
use App\Lib\PHPImap\Gmail\GmailConnection;
use App\Lib\PHPImap\QQ\QQConnection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImapController extends Controller
{
    private $_client = null;

    public function __construct(GmailConnection $gmailConnection, QQConnection $QQConnection,
                                Request $request)
    {
        try{
            switch ($request->route('type')) {
                case 'gmail':
                    $this->_client = $gmailConnection->setUsername(env('GMAIL_IMAP_USERNAME'))
                        ->setPassword(env('GMAIL_IMAP_PASSWORD'))
                        ->connect();
                    break;
                case 'qq':
                    $this->_client = $QQConnection->setUsername(env('QQ_IMAP_USERNAME'))
                        ->setPassword(env('QQ_IMAP_PASSWORD'))
                        ->connect();
                    break;
                default:
                    $this->_client = $QQConnection->setUsername(env('QQ_IMAP_USERNAME'))
                        ->setPassword(env('QQ_IMAP_PASSWORD'))
                        ->connect();
                    break;
            }
        }catch (\Exception $exception){
            return null;
        }
    }

    public function index()
    {
        $list = $this->_client->getPage();
        dump($list);
    }
}

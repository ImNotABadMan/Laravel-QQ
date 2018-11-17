<?php

namespace App\Http\Controllers\Imap;

use App\Lib\PHPImap\Gmail\GmailConnection;
use App\Lib\PHPImap\QQ\QQConnection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function index($type = 'qq', string $box = 'inbox', Request $request)
    {
        $mailboxes = $this->_client->getMailboxes();

        if($box != $this->_client->getCurrentMailbox()){
            if(in_array($box, $mailboxes)){
                $currentMailbox = $box;
            }else{
                $currentMailbox = 'inbox';
            }
            try{
                $this->_client->setCurrentMailbox($box);
            }catch (\Exception $exception){}
        }
        $page = $request->get('page', 1);

        $list = $this->_client->getPage($page);

        $paginator = new LengthAwarePaginator($list,
            $this->_client->getCount(), 25, $page, [
                'path' => '/imap/' . $type . '/' . $box
            ]);

        return view('imap.index')->with('list', $paginator)
            ->with('mailboxes', $mailboxes)
            ->with('currentMailbox', $currentMailbox);
    }
}

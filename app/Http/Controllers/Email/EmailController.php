<?php

namespace App\Http\Controllers\Email;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Packages\Imap\Imap;

class EmailController extends Controller
{
    private $_iMap;

    public function __construct(Imap $iMap)
    {
        $this->_iMap = $iMap;
    }

    //
    public function index()
    {
        $list = $this->_iMap->iMapList();
        dump($list);
        $emailList = $this->_iMap->iMapFetch(1, 5);
        dump($emailList);
        $check = $this->_iMap->iMapCheck();
        dump($check);
        foreach ($emailList as $item) {
            $body = $this->_iMap->iMapBody($item->msgno);
            echo $body;
            $structure = $this->_iMap->iMapStruct($item->msgno);
            dump($structure);
        }
    }
}

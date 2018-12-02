<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session = \Auth::createSessionDriver('web', null);
        $sessionName = $session->getName();
        if( session()->exists($sessionName) ){
            $user = User::join('qq_users', 'users.id', '=', 'qq_users.user_id')
                ->find(session()->get($sessionName),[
                    'name', 'avatar', 'gender', 'is_yellow_vip','province',
                    'city','year'
                ]);
        }else{
            $user = [];
        }

//        dump("realpath_cache_size: " . realpath_cache_size());
//        dump("memory_get_peak_usage: " . memory_get_peak_usage());
        return view('home', compact('user'));
    }
}

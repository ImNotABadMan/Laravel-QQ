<?php

namespace App\Http\Controllers\User;

use App\Repositories\QQHandler;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $_qqHandler;

    private $_userRepository;

    public function __construct(QQHandler $qqHandler, UserRepository $userRepository)
    {
        $this->_qqHandler = $qqHandler;
        $this->_userRepository = $userRepository;
    }

    public function index()
    {
        $oauthUrl = $this->_qqHandler->oauthUrl();
        return view('test.index', compact('oauthUrl'));
    }

    //
    public function test(Request $request)
    {

    }

    /**
     * 1、接受oauth返回来的code值
     * 2、使用code值来获取access_token
     * 3、用access token获取openid
     * 4、再用openid和access token获取user info
     */
    public function QQCallback(Request $request)
    {
        $code = $request->get('code');
        $state = $request->get('state');

        // 获得Auth类中的login success 存储用户id的session name
        $session = Auth::createSessionDriver('web', null);
        $sessionName = $session->getName();

        $id = session($sessionName, 0);
        // 获取用户信息
        $userInfo = $this->_qqHandler->getUserInfo($code, $id);
        // 保存用户信息
        $userInfo['oauth_type'] = 'qq';
        $id = $this->_userRepository->insertUserInfo($userInfo);


        if( session()->exists('login') ){
            session()->forget($sessionName);
        }
        session()->put($sessionName, $id);

        return \redirect()->route('home');
    }
}

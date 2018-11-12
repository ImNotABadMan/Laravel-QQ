<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-10-27
 * Time: 22:31
 */

namespace App\Repositories;


use Packages\QQ\src\Oauth;
use Packages\QQ\src\QQ;
use Packages\QQ\src\QQCommonTrait;

class QQHandler
{
    use QQCommonTrait;

    private $_qq;

    private $_oauth;

    public function __construct(QQ $qq, Oauth $oauth)
    {
        $this->_qq = $qq;
        $this->_oauth = $oauth;
    }

    protected function getOpenID($code, $userID = 0)
    {
        $openIDArr = [];
        $accessTokenArr = $this->_oauth->getAccessToken($code);
        if( isset($accessTokenArr['access_token']) ){
            $openID = $this->_qq->getOpenID();
            if($openID){
                $openIDArr['openid'] = $openID;
            }else{
                $openIDArr = $this->_qq->getOpenIDByAccessToken($accessTokenArr['access_token']);
                $this->_qq->saveOpenID($userID);
            }
        }
        return $openIDArr;
    }

    public function oauthUrl()
    {
        return $this->_oauth->getOauthUrl();
    }

    /*
    * 获得qq登录的用户信息
    */
    public function getUserInfo($code, $userID = 0)
    {
        $accessTokenArr = $this->_oauth->getAccessToken($code);
        $openIDArr = $this->getOpenID($code, $userID);
        if( !empty($openIDArr) ){
            $result = $this->_qq->getUserInfoWithOpenIDAndAccessToken($openIDArr['openid'],
                $accessTokenArr['access_token']);
            $result = array_merge($result, ['openid' => $openIDArr['openid']]);
        }

        return $result ?? [];
    }

}

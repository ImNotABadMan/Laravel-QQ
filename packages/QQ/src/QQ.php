<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-10-27
 * Time: 22:27
 */

namespace Packages\QQ\src;


use Illuminate\Support\Facades\DB;

class QQ
{
    use QQCommonTrait;

    // 获取openid
    private $_openIDUrl = 'https://graph.qq.com/oauth2.0/me';

    private $_openParams = [
        'access_token' => ''
    ];

    // 获取user info
    private $_url = 'https://graph.qq.com/user/get_user_info';

    // 应用app id
    private $_appID = '';

    // access token
    private $_accessToken = '';

    // 应用app id
    private $_oauthConsumerKey = '';

    private $_openID = [];

    private $_params = [
        'access_token' => '',
        'oauth_consumer_key' => '',
        'openid' => ''
    ];

    public function __construct()
    {
        $this->_params['oauth_consumer_key'] = $this->_appID = config('qq.app_id');
    }

    /**
     * 用openid 和access token获取user info
     * @return array
    */
    public function getUserInfoWithOpenIDAndAccessToken($openID, $accessToken)
    {
        $this->_params['access_token'] = $accessToken;
        $this->_params['openid'] = $openID;
        $url = $this->_url . "?" . http_build_query($this->_params);

        $result = file_get_contents($url);
        $result = json_decode($result, true);

        return $result;
    }

    /**
     * 通过oauth得到的access token令牌，去获取登录用户的openID
     * @return array
    */
    public function getOpenIDByAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
        $this->_openParams['access_token'] = $this->_accessToken;
        $url = $this->_openIDUrl . "?" . http_build_query($this->_openParams);

        $result = file_get_contents($url);
        $result = $this->parseQuery($result);
        $this->_openID = $result;

        return $result;
    }

    /**
     * 存储openid
     * @return bool
    */
    public function saveOpenID($userID)
    {
        return DB::table('users')
            ->updateOrInsert([
                'openid' => $this->_openID['openid'],
                'oauth_type' => 'qq',
                'email' => $this->_openID['openid'],
            ],[
                'email' => $this->_openID['openid'],
                'openid' => $this->_openID['openid'],
                'oauth_type' => 'qq',
            ]);
    }

    /**
     * 获取openid
     * @return array
    */
    public function getOpenID()
    {
        // 数据库有没有，没有就返回得到的openIDArr
        if(!empty($this->_openID['openid'])) {
            $openID = DB::table('users')->where([
                'openid' => $this->_openID['openid']
            ])->first(['openid'])->toArray();
        }
        return $openID ?? $this->_openID;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-10-27
 * Time: 22:50
 */

namespace Packages\QQ\src;


class Oauth
{
    use QQCommonTrait;

    // 1、oauth认证，获得QQ颁发的code值，表示入门券
    private $_oauthUrl = 'https://graph.qq.com/oauth2.0/authorize';

    private $_redirectUrl = '';

    // 应用appID
    private $_clientID = '';

    private $_scopes = [
        'get_user_info' => 'get_user_info'
    ];

    private $_oauthParams = [
        'response_type' => 'code',
        'client_id'     => '',
        'redirect_uri'  => '',
        'state'         => 'bin',
        'scope'         => '',
        'display'       => 'PC'
    ];

    // step2 get access token params
    private $_tokenUrl = 'https://graph.qq.com/oauth2.0/token';

    // 应用的app id
    private $_appID = '';

    // 应用的aoo secret
    private $_appSecret = '';

    private $_tokenParams = [
        'grant_type'    => 'authorization_code',
        'client_id'     => '',
        'client_secret' => '',
        'redirect_uri'  => '',
        'code'          => '',
    ];

    // 刷新access token的令牌
    private $_refreshUrl = 'https://graph.qq.com/oauth2.0/token';

    private $_refreshParams = [
        'grant_type'    => 'refresh_token',
        'client_id'     => '',
        'client_secret' => '',
        'refresh_token' => '',
    ];

    public function __construct()
    {
        $this->_redirectUrl = config('qq.redirect_url');
        $this->_oauthParams['redirect_uri'] = $this->_redirectUrl;
        $this->_oauthParams['client_id'] = $this->_clientID = config('qq.client_id');
        $this->_oauthParams['scope'] = $this->_scopes['get_user_info'];

        // step 2 get access token
        $this->_tokenParams['client_id'] = $this->_appID = config('qq.app_id');
        $this->_tokenParams['client_secret'] = $this->_appSecret = config('qq.app_secret');
        $this->_tokenParams['redirect_uri'] = config('qq.redirect_url');

        // access_token 有效期为3个月
        // 自动续期access_token
        $this->_refreshParams['client_id'] = $this->_appID = config('qq.app_id');
        $this->_refreshParams['client_secret'] = $this->_appSecret = config('qq.app_secret');
    }

    /**
     * 获取access token
    */
    protected function getAccessTokenFromLocal()
    {
        return unserialize(session()->get('access_token', ''));
    }

    /**
     * 存储access token
    */
    protected function storeAccessToken($accessTokenArr)
    {
        session()->put('access_token', serialize($accessTokenArr));
        return $accessTokenArr;
    }

    /**
     * 返回qq oauth2.0 的url
    */
    public function getOauthUrl()
    {
        $httpQuery = http_build_query($this->_oauthParams);
        $url = $this->_oauthUrl . "?" . $httpQuery;

        return $url;
    }

    /**
     *  获取access token的url
     */
    protected function getAccessTokenUrl($code)
    {
        $this->_tokenParams['code'] = $code;
        $url = $this->_tokenUrl . "?" . http_build_query($this->_tokenParams);

        return $url;
    }

    /**
     *  Access_Token的有效期默认是3个月，过期后需要用户重新授权才能获得新的Access_Token。
     *  本步骤可以实现授权自动续期，避免要求用户再次授权的操作，提升用户体验。
     */
    protected function refreshAccessTokenUrl($refreshToken)
    {
        $this->_refreshParams['refresh_token'] = $refreshToken;
        $url = $this->_refreshUrl . "?" . http_build_query($this->_refreshParams);

        return $url;
    }

    /**
     * 获取oauth中的access token
     * @return array
    */

    public function getAccessToken($code)
    {
        $accessToken = $this->getAccessTokenFromLocal();

        if( !isset($accessToken['access_token']) ) {
            $tokenUrl = $this->getAccessTokenUrl($code);
            // 第二步，得到第一步返回来的code值，再使用第二个api获得access_token
            $accessToken = file_get_contents($tokenUrl);

            $accessToken = $this->parseQuery($accessToken);

            $this->storeAccessToken($accessToken);
        }
        return $accessToken;
    }


}

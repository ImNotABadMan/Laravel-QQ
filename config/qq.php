<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2018/11/20
 * Time: 15:24
 */

return [

    'client_id'     => env('QQ_CLIENT_ID', ''),

    'app_id'        => env('QQ_APP_ID', ''),

    'app_secret'    => env('QQ_APP_SECRET',''),

    'redirect_url'  => env('APP_URL', 'localhost') . '/user/callback/qq'
];

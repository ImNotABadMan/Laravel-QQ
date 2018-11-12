<?php
/**
 * Created by PhpStorm.
 * User: Binge
 * Date: 2018-11-11
 * Time: 22:11
 */

return [
    'qq' => [
        'server' => 'imap.qq.com',
        'user' => env('QQ_IMAP_USERNAME'),
        'password' => env('QQ_IMAP_PASSWORD')
    ],

    'gmail' => [
        'server' => 'imap.gmail.com',
        'user' => env('GMAIL_IMAP_USERNAME'),
        'password' => env('GMAIL_IMAP_PASSWORD')
    ]
];

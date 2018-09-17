<?php
/**
 * Created by PhpStorm.
 * User: elliot
 * Date: 13/09/2018
 * Time: 08:50
 */

return [
    'wx_config' => [
        'debug' => true,
        'app_id' => 'wxcc953a81e7093534',
        'secret' => '4bd6aae141fe587ab65983027ee4b4ae',
        'token' => 'wanglongtest',
        'log' => [
            'level' => 'debug',
            'file' => '/tmp/oauth_callback',
        ],
        'oauth' => [
            'scopes' => ['snsapi_base'],
            'callback' => '/wx/oauth_callback',
        ],
    ],
    'wx_buttons' => [
        [
            'name' => '主页',
            'sub_button' => [
                [],
                []
            ],
        ],
        [
            'type' => 'view',
            'name' => '我的',
            'url' => '',
        ],
    ],
];

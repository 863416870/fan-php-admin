<?php


return [
    // 微信开放平台接口

    // 小程序支付参数
    'xcx'     => [
        'appid'      => '',
        'appsecret'  => '',
        'mch_id'     => '',
        'mch_key'    => '',
        'ssl_p12'    => __DIR__ . '/cert/1332187001_20181030_cert.p12',
        'cache_path' => env('runtime_path') . 'wechat' . DIRECTORY_SEPARATOR,
    ],
    //微信公众号配置信息
    "gzh"      => [
        'token'          => 'fanguojie2',
        'appid'          => 'wxbbbe278acf225756',
        'appsecret'      => '05b26dd50b7bf62ba987e484d43ded77',
        'encodingaeskey' => 'wbbK5LHIf9BEYXBckjthSaX7PxkMKUiiP6GwdTXWOOW',
    ]
];

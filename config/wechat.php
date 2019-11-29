<?php


return [
    // 微信开放平台接口

    // 小程序支付参数
    'miniapp'     => [
        'appid'      => '',
        'appsecret'  => '',
        'mch_id'     => '',
        'mch_key'    => '',
        'ssl_p12'    => __DIR__ . '/cert/1332187001_20181030_cert.p12',
        'cache_path' => env('runtime_path') . 'wechat' . DIRECTORY_SEPARATOR,
    ],
];

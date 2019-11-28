<?php

namespace app\wechat\controller;


use think\Controller;
use think\facade\Hook;
use think\Request;
use think\facade\Log;

class User extends Controller
{
    /**
     * 账户登陆
     * @param Request $request
     * @validate('LoginForm')
     * @return array
     * @throws \think\Exception
     */

    public $Crypt;
    public function __construct()
    {
//        const APP_ID = "wx5c418a3419f75d9d";
//        const APP_SECRET = "a1b9bc964d69111742d36e96b46093e2";
        $config = [
            'token'          => 'test',
            'appid'          => 'wx6e9b1cf5d85e0f3c',
            'appsecret'      => '40d531b0b5e1fbb0cb6d5b052a192ace',
            'encodingaeskey' => 'BJIUzE0gqlWy0GxfPp4J1oPTBmOrNDIGPNav1YFH5Z5',
            // 配置商户支付参数（可选，在使用支付功能时需要）
            'mch_id'         => "1235704602",
            'mch_key'        => 'IKI4kpHjU94ji3oqre5zYaQMwLHuZPmj',
            // 配置商户支付双向证书目录（可选，在使用退款|打款|红包时需要）
            'ssl_key'        => '',
            'ssl_cer'        => '',
            // 缓存目录配置（可选，需拥有读写权限）
            'cache_path'     => '',
        ];
        $this->Crypt = new \app\wechat\lib\WeMini\Crypt($config);
    }

    public function login(Request $request)
    {

        $params = $request->get();
        Log::write("code".json_encode($params));
        $info = $this->Crypt->session($params['code']);
        Log::write("code".json_encode($info));
        return writeJson(201, $info, '成功');
    }



}
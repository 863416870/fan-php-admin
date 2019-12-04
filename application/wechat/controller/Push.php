<?php

namespace app\wechat\controller;

use think\Controller;
use app\wechat\lib\WeChat\Contracts\BasicPushEvent;
use think\facade\Log;
/**
 * 微信公众号认证与消息推送处理
 * Class Push
 * @package app\wechat\controller\api
 */
class Push extends Controller
{
    public $config;
    public function __construct()
    {

        $this->config = [
            'token'          => 'fanguojie2',
            'appid'          => 'wxbbbe278acf225756',
            'appsecret'      => '05b26dd50b7bf62ba987e484d43ded77',
            'encodingaeskey' => 'wbbK5LHIf9BEYXBckjthSaX7PxkMKUiiP6GwdTXWOOW',
        ];

    }

    public function index(){
        new BasicPushEvent($this->config);
        return writeJson(201, [], '成功');
    }

    public function login(){

        return writeJson(201, [], '成功');
    }

}

<?php

namespace app\wechat\controller;

use think\Controller;
use app\wechat\lib\WeChat\Contracts\BasicPushEvent;
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

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = "7d50ceef1198b6e5ee8b1d40a6ba48e6";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
//        new BasicPushEvent($this->config);
//        return writeJson(201, [], '成功');
    }

    public function login(){

        return writeJson(201, [], '成功');
    }

}

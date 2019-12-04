<?php

namespace app\wechat\controller\api;

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
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $token     = 'fanguojie2';
        $signature = $_GET['signature'];
        $array     = array($timestamp,$nonce,$token);
        sort($array);
        //将排序后的三个参数拼接之后参数拼接之后进行sha1加密
        $tmpstr    = implode('',$array);
        $tmpstr    = sha1($tmpstr);
        //将加密后的字符串与signature进行对比；
        Log::error("tmpstr------------".$tmpstr);
        if($tmpstr == $signature && isset($_GET['echostr'])){
            Log::error($_GET['echostr']);
            echo $_GET['echostr'];
            exit;
        }else{
            return writeJson(201, [], '成功');
        }

//        new BasicPushEvent($this->config);
//        return writeJson(201, [], '成功');
    }

    public function login(){

        return writeJson(201, [], '成功');
    }

}

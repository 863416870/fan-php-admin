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
    public function login(Request $request)
    {

        $params = $request->post();

        Log::write("code".json_encode($params));
    }



}
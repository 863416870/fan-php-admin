<?php

namespace app\api\controller\system;

use app\lib\token\Token;
use app\api\model\system\User as FUser;
use think\App;
use think\Controller;
use think\facade\Hook;
use think\Request;

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

        $user = FUser::verify($params['username'], $params['password']);
        $result = Token::getToken($user);

        Hook::listen('logger', array('uid' => $user->id, 'nickname' => $user->username, 'msg' => '登陆成功获取了令牌'));
        return $result;
    }

    /**
     * @return mixed
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function getInformation()
    {
        $user = Token::getCurrentUser();
        return $user;
    }


    /**
     * @param Request $request
     * @param ('url','头像url','require|url')
     * @return \think\response\Json
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function setAvatar(Request $request)
    {
        $url = $request->put('avatar');
        $uid = Token::getCurrentUID();
        LinUser::updateUserAvatar($uid, $url);

        return writeJson(201, '', '更新头像成功');
    }

    /**
     * @return array
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function refresh()
    {
        $result = Token::refreshToken();
        return $result;
    }

}
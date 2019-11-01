<?php
namespace app\api\behavior;

use app\lib\token\Token;
use app\lib\exception\logger\LoggerException;
use app\common\model\Log as FLog;
use think\facade\Request;
use think\facade\Response;

class Logger
{
    /**
     * @param $params
     * @throws LoggerException
     * @throws \app\lib\exception\token\TokenException
     * @throws \think\Exception
     */
    public function run($params)
    {

        // 行为逻辑
        if (empty($params)) {
            throw new LoggerException([
                'msg' => '日志信息不能为空'
            ]);
        }

        if (is_array($params)) {
            list('uid' => $uid, 'nickname' => $nickname, 'msg' => $message) = $params;
        } else {
            $uid = Token::getCurrentUID();
            $nickname = Token::getCurrentName();
            $message = $params;
        }

        $data = [
            'message' => $nickname . $message,
            'user_id' => $uid,
            'user_name' => $nickname,
            'status_code' => Response::getCode(),
            'method' => Request::method(),
            'path' => Request::path(),
            'authority' => ''
        ];

        FLog::create($data);

    }
}
<?php
/**
 * Created by PhpStorm
 * User: 范国洁
 * Date: 2019/9/1
 * Time: 12:42
 */

namespace app\common\behavior;

use app\common\exception\BaseException;
use app\common\model\Log;
use app\common\util\ExceptionUtil;
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
            throw new BaseException(
                ExceptionUtil::LoggerExceptionMap('日志信息不能为空')
                );
        }

        if (is_array($params)) {
            list('uid' => $uid, 'nickname' => $nickname, 'msg' => $message) = $params;
        } else {
            $uid = "fanguojie";
            $nickname = "xiaofan";
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

        Log::create($data);

    }
}
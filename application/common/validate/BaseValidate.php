<?php
/**
 * Created by PhpStorm
 * User: 范国洁
 * Date: 2019/8/31
 * Time: 15:39
 */

namespace app\common\validate;

use app\lib\exception\parameter\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @return bool
     * @throws ParameterException
     */
    public function goCheck()
    {
        //获取HTTP传入的参数
        $params = Request::param();
        //对这些参数做校验
        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        } else {
            return true;
        }
    }
}
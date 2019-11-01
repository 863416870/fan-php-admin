<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/1
 * Time: 16:12
 */

namespace app\lib\exception\role;

use app\common\exception\BaseException;

class RoleException extends BaseException
{
    public $code = 400;
    public $msg  = '分组错误';
    public $error_code  = 30000;
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/16
 * Time: 11:30
 */

namespace app\lib\exception\logger;

use app\common\exception\BaseException;

class LoggerException extends BaseException
{
    public $code = 400;
    public $msg  = '日志信息不能为空';
    public $error_code = 40001;
}
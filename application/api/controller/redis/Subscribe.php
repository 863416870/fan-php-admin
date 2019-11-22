<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/22
 * Time: 14:42
 */
namespace app\api\controller\redis;

use app\lib\redis\Base as RedisBase;
use think\Log;

//use app\common\tools\Log;


class Subscribe
{
    private $log;
    public function __construct()
    {
        $this->log = new Log();
    }

    public function sub()
    {
        $this->log->write(time()."__超时任务__:");

        $redis = new RedisBase();
        $redis->setOption();

        $redis->psubscribe(array('__keyevent@0__:expired'), function ($redis, $pattern, $chan, $msg) {
            //逻辑处理
            $this->log->write('[1]--过期事件的订阅 ' . json_encode($msg));
            $this->log->write(json_encode($redis));
            $this->log->write(json_encode($pattern));
            $this->log->write(json_encode($chan));
            $this->log->write($msg);
        });
    }
}